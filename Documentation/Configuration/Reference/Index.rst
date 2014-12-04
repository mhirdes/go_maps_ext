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
         integer
   
   Description
         Displays all addresses from this PID and additionally from the TCA
         field
   
   Default


.. container:: table-row

   Property
         settings.googleMapsLibrary
   
   Data type
         String
   
   Description
         Configure the URL form which the Google Maps JS is loaded
   
   Default
         //maps.google.com/maps/api/js?v=3.17&sensor=false


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
         language
   
   Data type
         String
   
   Description
         Language Code for the API, for details look here:
         `https://spreadsheets.google.com/pub?key=p9pdwsai2hDMsLkXsoM05KQ&gid=1
         <https://spreadsheets.google.com/pub?key=p9pdwsai2hDMsLkXsoM05KQ&gid=1
         >`_
         
         If not defined the language depends on the browser settings.
   
   Default
         config.language


.. ###### END~OF~TABLE ######


Example
~~~~~~~

::

   plugin.tx_gomapsext.settings.infoWindow.openByClick = 1
   plugin.tx_gomapsext.settings.infoWindow.closeByClick = 1

