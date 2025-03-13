<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Directive;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Mutation;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationCollection;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Scope;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceKeyword;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceScheme;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\UriValue;
use TYPO3\CMS\Core\Type\Map;

$collection = new MutationCollection(
    new Mutation(
        MutationMode::Extend,
        Directive::ScriptSrcElem,
        SourceKeyword::nonceProxy,
        new UriValue('https://maps.google.com'),
    ),
    new Mutation(
        MutationMode::Extend,
        Directive::ImgSrc,
        // @todo should be UriValue (which currently does not support scheme wildcards)
        new UriValue('https://*.googleapis.com'),
        new UriValue('https://*.gstatic.com'),
        new UriValue('*.google.com'),
        new UriValue('*.googleusercontent.com'),
    ),
    new Mutation(
        MutationMode::Extend,
        Directive::FrameSrc,
        new UriValue('*.google.com'),
    ),
    new Mutation(
        MutationMode::Extend,
        Directive::ConnectSrc,
        new UriValue('*.google.com'),
        new UriValue('https://*.googleapis.com'),
        new UriValue('https://*.gstatic.com'),
        SourceScheme::blob, // thx Google!
        SourceScheme::data, // thx Google!
    ),
    new Mutation(
        MutationMode::Extend,
        Directive::FontSrc,
        new UriValue('https://fonts.gstatic.com'),
    ),
    new Mutation(
        MutationMode::Extend,
        Directive::StyleSrcElem,
        new UriValue('https://maps.google.com'),
        new UriValue('https://fonts.gstatic.com'),
        new UriValue('*.google.com'),
        new UriValue('https://fonts.googleapis.com'),
    ),
    new Mutation(
        MutationMode::Extend,
        Directive::WorkerSrc,
        SourceScheme::blob,
    ),
);

return Map::fromEntries([
        // Provide declarations for the backend
        Scope::backend(),
        $collection
    ],
    [
        // Provide declarations for the frontend
        Scope::frontend(),
        $collection
    ]
);
