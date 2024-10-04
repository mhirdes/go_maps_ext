<?php

namespace Clickstorm\GoMapsExt\Controller;

use Clickstorm\CsTemplates\Domain\Model\Page;
use Psr\Http\Message\ResponseInterface;

use Clickstorm\GoMapsExt\Domain\Model\Map;
use Clickstorm\GoMapsExt\Domain\Repository\AddressRepository;
use Clickstorm\GoMapsExt\Domain\Repository\KeyRepository;
use Clickstorm\GoMapsExt\Domain\Repository\MapRepository;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;

class MapController extends ActionController
{
    protected ?MapRepository $mapRepository = null;

    protected ?AddressRepository $addressRepository = null;

    protected ?KeyRepository $keyRepository = null;

    protected string $googleMapsLibrary = '';

    public function injectMapRepository(MapRepository $mapRepository): void
    {
        $this->mapRepository = $mapRepository;
    }

    public function injectAddressRepository(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function injectKeyRepository(KeyRepository $keyRepository): void
    {
        $this->keyRepository = $keyRepository;
    }

    public function initializeAction(): void
    {
        $extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('go_maps_ext');

        /** @var PageRenderer $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $addJsMethod = 'addJs';

        if ($extConf['footerJS'] === '1') {
            $addJsMethod = 'addJsFooter';
        }

        $this->googleMapsLibrary = $this->settings['googleMapsLibrary'] ?? '//maps.google.com/maps/api/js?v=weekly&callback=goMapsExtLoaded';

        // get the apiKey
        $apiKey = $this->getFinalApiKey();

        if ($apiKey) {
            $this->googleMapsLibrary .= '&key=' . $apiKey;
        }

        if ($this->settings['forceLanguage']) {
            /** @var SiteLanguage $language */
            $language = $GLOBALS['TYPO3_REQUEST']->getAttribute('language');
            $this->googleMapsLibrary .= '&language=' . $language->getLocale()->getLanguageCode();
        }

        if (!$this->settings['preview']['enabled'] && !$extConf['include_google_api_manually']) {
            $pageRenderer->addJsFooterInlineCode(
                'txGoMapsExtLibrary',
                'window.txGoMapsExtLibrary = "' .$this->googleMapsLibrary . '";'
            );
        }

        $pathPrefix = 'EXT:' . $this->request->getControllerExtensionKey() . '/';

        if ($extConf['include_manually'] !== '1') {
            $scripts[] = $pathPrefix . 'Resources/Public/Scripts/markerclusterer_compiled.js';
            $scripts[] = $pathPrefix . 'Resources/Public/Scripts/gomapsext.js';

            if ($this->settings['preview']['enabled']) {
                $scripts[] = $pathPrefix . 'Resources/Public/Scripts/gomapsext.preview.js';
            }

            foreach ($scripts as $script) {
                $pageRenderer->{$addJsMethod . 'File'}($script);
            }
        }
    }

    /**
     * show action
     *
     * @param Map|null $map
     * @return ResponseInterface
     * @throws NoSuchArgumentException
     * @throws InvalidQueryException
     */
    public function showAction(Map $map = null): ResponseInterface
    {
        $categoriesArray = [];

        // get current map
        if(is_null($map) && isset($this->settings['map'])) {
            /* @var Map $map */
            $map = $this->mapRepository->findByUid($this->settings['map']);
        }

        if (is_null($map)) {
            return $this->htmlResponse();
        }

        // find addresses
        $addresses = $map->getAddresses();

        // no addresses related to the map, try to find some from the storagePid
        if ($addresses->count() === 0 && !empty($this->settings['storagePid'])) {
            // @extensionScannerIgnoreLine
            $pid = str_ireplace('this', $GLOBALS['TSFE']->id, $this->settings['storagePid']);
            $addresses = $this->addressRepository->findAllAddresses($map, $pid);
        }

        // respect category param
        $addresses = $addresses->toArray();
        $activeCategoryByUrl = $this->request->hasArgument('category') ?
            (int)$this->request->getArgument('category') : 0;


        // get categories
        if ($map->isShowCategories() && count($addresses) > 0) {
            foreach ($addresses as $addressKey => $address) {
                /* @var \Clickstorm\GoMapsExt\Domain\Model\Address $address */
                $addressCategories = $address->getCategories();
                $addressHasActiveCategory = false;
                if ($addressCategories && $addressCategories->count() > 0) {
                    /* @var \Clickstorm\GoMapsExt\Domain\Model\Category $addressCategory */
                    foreach ($addressCategories as $addressCategory) {
                        $categoriesArray[$addressCategory->getSorting()] = $addressCategory;
                        if ($activeCategoryByUrl > 0 && $addressCategory->getUid() === $activeCategoryByUrl) {
                            $addressHasActiveCategory = true;
                        }
                    }
                }
                // filter by active category
                if ($activeCategoryByUrl > 0 && !$addressHasActiveCategory) {
                    unset($addresses[$addressKey]);
                }
            }
            if ($categoriesArray) {
                ksort($categoriesArray);
            }
        }

        $this->view->assignMultiple([
            'request' => $this->request->getArguments(),
            'map' => $map,
            'addresses' => $addresses,
            'categories' => $categoriesArray,
            'googleMapsLibrary' => $this->googleMapsLibrary
        ]);
        return $this->htmlResponse();
    }

    /**
     * either apiKey from Flexform or TypoScript
     */
    protected function getFinalApiKey(): string
    {
        if (isset($this->settings['ff']) && is_array($this->settings['ff']) && $this->settings['ff']['apiKey']) {
            $apiKeyRecord = $this->keyRepository->findByUid((int)$this->settings['ff']['apiKey']);
            if ($apiKeyRecord) {
                return $apiKeyRecord->getApiKey();
            }
        }

        return $this->settings['apiKey'] ?: '';
    }
}
