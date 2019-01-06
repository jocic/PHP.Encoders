<?php
    
    /*******************************************************************\
    |* Author: Djordje Jocic                                           *|
    |* Year: 2019                                                      *|
    |* License: MIT License (MIT)                                      *|
    |* =============================================================== *|
    |* Personal Website: http://www.djordjejocic.com/                  *|
    |* =============================================================== *|
    |* Permission is hereby granted, free of charge, to any person     *|
    |* obtaining a copy of this software and associated documentation  *|
    |* files (the "Software"), to deal in the Software without         *|
    |* restriction, including without limitation the rights to use,    *|
    |* copy, modify, merge, publish, distribute, sublicense, and/or    *|
    |* sell copies of the Software, and to permit persons to whom the  *|
    |* Software is furnished to do so, subject to the following        *|
    |* conditions.                                                     *|
    |* --------------------------------------------------------------- *|
    |* The above copyright notice and this permission notice shall be  *|
    |* included in all copies or substantial portions of the Software. *|
    |* --------------------------------------------------------------- *|
    |* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, *|
    |* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES *|
    |* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND        *|
    |* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT     *|
    |* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,    *|
    |* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, RISING     *|
    |* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR   *|
    |* OTHER DEALINGS IN THE SOFTWARE.                                 *|
    \*******************************************************************/
    
    namespace Jocic\Encoders\Base;
    
    use Jocic\Encoders\DefaultInterface;
    
    /**
     * <i>BaseCore</i> class contains methods that serve the same function for
     * all base implementations.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2019 All Rights Reserved
     * @version   1.0.0
     */
    
    class BaseCore
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        // CORE CONSTANTS GO HERE
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        // CORE VARIABLES GO HERE
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        // MAGIC FUNCTIONS GO HERE
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        // GET METHODS GO HERE
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        // SET METHODS GO HERE
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        // CORE METHODS GO HERE
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        // CHECK METHODS GO HERE
        
        /********************\
        |* ENCODING METHODS *|
        \********************/
        
        // ENCODING METHODS GO HERE
        
        /********************\
        |* DECODING METHODS *|
        \********************/
        
        /**
         * Converts provided encoding into chunks based on the base table.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $encoding
         *   Encoding that needs to be converted to chunks.
         * @return array
         *   Array containing chunks.
         */
        
        public function convertEncodingToChunks($encoding)
        {
            // Core Variables
            
            $baseTable = $this->getBaseTable();
            $chunks    = [];
            
            // Other Variables
            
            $flippedTable = array_flip($baseTable);
            $characters   = str_split($encoding);
            
            // Step 1 - Check Encoding
            
            if (!$this->isEncodingValid($encoding))
            {
                throw new \Exception("Invalid encoding provided, it can't be " .
                    "converted. Encoding: \"$encoding\"");
            }
            
            // Step 2 - Convert Encoding
            
            foreach ($characters as $character)
            {
                if (isset($flippedTable[$character]))
                {
                    $chunks[] = $flippedTable[$character];
                }
            }
            
            return $chunks;
        }
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        // OTHER METHODS GO HERE
    }
    
?>
