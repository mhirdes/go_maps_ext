.. include:: ../../Includes.txt

Reference
^^^^^^^^^


Extension Configurations
"""""""""""""""""""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         include\_library

   Data type
         boolean

   Description
         Use JavaScript Library from Extension: jQuery

   Default
         0


.. container:: table-row

   Property
         include\_manually

   Data type
         boolean

   Description
         Include the JavaScript from extension manually

   Default
         0


.. container:: table-row

   Property
         include\_google\_api\_manually

   Data type
         boolean

   Description
         Include the Google JavaScript API manually

   Default
         0




.. container:: table-row

   Property
         footerJS

   Data type
         boolean

   Description
         Adds all JavaScript to the footer of the body instead of the head

   Default
         1


.. ###### END~OF~TABLE ######


Constants
""""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         view.templateRootPath

   Data type
         file

   Description
         Path to template root (FE)

   Default
         EXT:go\_maps\_ext/Resources/Private/Templates/


.. container:: table-row

   Property
         view.layoutRootPath

   Data type
         file

   Description
         Path to template layouts (FE)

   Default
         EXT:go\_maps\_ext/Resources/Private/Layouts/


.. container:: table-row

   Property
         view.partialRootPath

   Data type
         file

   Description
         Path to template partials (FE)

   Default
         EXT:go\_maps\_ext/Resources/Private/Partials/


.. container:: table-row

   Property
         settings.storagePid

   Data type
         integer/String

   Description
         If integer is set, it will display all addresses from this PID and additionally from the TCA, if the string "this" is set, it will show the addresses from the current active page uid (i.e. settings.storagePid = "this")
         field


.. container:: table-row

   Property
         settings.apiKey

   Data type
         String

   Description
         Set the default API key. Can also be set by an editor in the FlexForm of an Plugin. More information_. Get your apiKey_.


.. container:: table-row

   Property
         settings.googleMapsLibrary

   Data type
         String

   Description
         Configure the URL form which the Google Maps JS is loaded

   Default
         //maps.google.com/maps/api/js?v=3.28


.. container:: table-row

   Property
         settings.infoWindow.openByClick

   Data type
         boolean

   Description
         Open InfoWindows by click instead of mouse over. Global configuration
         for all addresses.

   Default
         0


.. container:: table-row

   Property
         settings.infoWindow.closeByClick

   Data type
         boolean

   Description
         Close InfoWindows by click instead of mouse out. Global configuration
         for all addresses.

   Default
         0


.. container:: table-row

   Property
         settings.infoWindow.imageMaxWidth

   Data type
         String

   Description
         Set the max. width of the image in InfoWindows. Global configuration
         for all addresses.

   Default
         654


.. container:: table-row

   Property
         settings.preview.enabled

   Data type
         boolean

   Description
         Load map only when user accepted. A preview text or image will be displayed instead.

   Default
         1


.. container:: table-row

   Property
         settings.preview.image

   Data type
         String

   Description
         Define a fallback image for all previews. If there is no image set on the map, this image will be shown.
         If both is not set, a link will be displayed. Much more is possible if you overwrite the partial.


.. container:: table-row

   Property
         settings.preview.setCookieToShowMapAlways

   Data type
         boolean

   Description
         If the user wants to see a map once, it will be saved in the session cookie. Subsequently, all maps are loaded
         on a page as long as the user does not close the session.

   Default
         0


.. container:: table-row

   Property
         forceLanguage

   Data type
         boolean

   Description
         Force the language of the map to be equal to the page language. If false the language depends on the
         browser settings.

   Default
         1


.. ###### END~OF~TABLE ######

.. _information: http://googlegeodevelopers.blogspot.de/2016/06/building-for-scale-updates-to-google.html
.. _apiKey: https://developers.google.com/maps/documentation/javascript/get-api-key
.. _details: https://spreadsheets.google.com/pub?key=p9pdwsai2hDMsLkXsoM05KQ&gid=1

Example
~~~~~~~

::

   plugin.tx_gomapsext.settings.infoWindow.openByClick = 1
   plugin.tx_gomapsext.settings.infoWindow.closeByClick = 1


