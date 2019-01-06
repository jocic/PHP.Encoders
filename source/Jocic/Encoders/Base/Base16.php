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
     * <i>Base16</i> class is used for encoding data in <i>Base 16</i> format.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2019 All Rights Reserved
     * @version   1.0.0
     */
    
    class Base16 extends BaseCore implements DefaultInterface, BaseInterface
    {
        /******************\
        |* CORE CONSTANTS *|
        \******************/
        
        // CORE CONSTANTS GO HERE
        
        /******************\
        |* CORE VARIABLES *|
        \******************/
        
        /**
         * Array containing characters of the encoding table for <i>Base 16</i>
         * encoding per <i>RFC 4648</i> specifications.
         * 
         * Note: Review page 10 of the mentioned document for more information.
         * 
         * @var    array
         * @access private
         */
        
        private $baseTable = [
            "0", "1", "2", "3", "4", "5", "6", "7",
            "8", "9", "A", "B", "C", "D", "E", "F"
        ];
        
        /*******************\
        |* MAGIC FUNCTIONS *|
        \*******************/
        
        // MAGIC FUNCTIONS GO HERE
        
        /***************\
        |* GET METHODS *|
        \***************/
        
        /**
         * Returns an array containing characters of the encoding table for
         * <i>Base 16</i> encoding per <i>RFC 4648</i> specifications.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @return array
         *   Array containing characters of the encoding table.
         */
        
        public function getBaseTable()
        {
            // Logic
            
            return $this->baseTable;
        }
        
        /**
         * Returns an empty string as <i>Base 16</i> encoding isn't padded.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @return string
         *   String containing a single character used for padding-purposes.
         */
        
        public function getBasePadding()
        {
            // Logic
            
            return "";
        }
        
        /***************\
        |* SET METHODS *|
        \***************/
        
        // SET METHODS GO HERE
        
        /****************\
        |* CORE METHODS *|
        \****************/
        
        /**
         * Encodes a provided string to <i>Base 16</i> encoding.
         *  
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $input
         *   Input string that needs to be encoded.
         * @return string
         *   Encoded input per used specifications.
         */
        
        public function encode($input)
        {
            // Core Variables
            
            $baseTable = $this->getBaseTable();
            $output    = "";
            $chunks    = [];
            
            // Step 1 - Handle Empty Input
            
            if ($input == "")
            {
                return "";
            }
            
            // Step 2 - Split Input Into 4-bit Chunks
            
            $chunks = $this->convertInputToChunks($input);
            
            // Step 3 - Process Chunks
            
            foreach ($chunks as $chunk)
            {
                $output .= $baseTable[$chunk];
            }
            
            // Step 4 - Apply Padding & Return Encoding
            
            return $output;
        }
        
        /**
         * Decodes a provided string from <i>Base 16</i> encoding.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $input
         *   Input string that needs to be decoded.
         * @return string
         *   Decoded input per used specifications.
         */
        
        public function decode($input)
        {
            // Core Variables
            
            $chunks = [];
            
            // Step 1 - Handle Empty Input
            
            if ($input == "")
            {
                return "";
            }
            
            // Step 2 - Decode Input Into 4-bit Chunks
            
            $chunks = $this->convertEncodingToChunks($input);
            
            // Step 3 - Merge Dervided Chunks
            
            $input = $this->mergeEncodingChunks($chunks);
            
            // Step 4 - Return Decoding
            
            return $input;
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Checks if the <i>Base 16</i> encoding is valid or not.
         * 
         * Note: Invalid encodings should be rejected per section <i>3.3</i>
         * in the <i>RFC 4648</i> specifications.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $encoding
         *   <i>Base 16</i> encoding that needs to be checked.
         * @return bool
         *   Value <i>True</i> if encoding is valid, and vice versa.
         */
        
        public function isEncodingValid($encoding)
        {
            // Core Variables
            
            $baseTable = $this->getBaseTable();
            
            // Other Variables
            
            $characters = [];
            
            // Step 1 - Check If Empty
            
            if ($encoding == "")
            {
                return true;
            }
            
            // Step 2 - Check General Form
            
            if (!preg_match("/^([A-z0-9]+)?$/", $encoding))
            {
                return false;
            }
            
            // Step 3 - Generate Character Array
            
            $characters = str_split($encoding);
            
            // Step 4 - Check Characters
            
            foreach ($characters as $character)
            {
                if (!in_array($character, $baseTable))
                {
                    return false;
                }
            }
            
            return true;
        }
        
        /********************\
        |* ENCODING METHODS *|
        \********************/
        
        /**
         * Converts provided string into chunks - 4-bit values.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @param string $input
         *   Input that needs to be converted to chunks.
         * @return array
         *   Array containing chunks (4-bit values).
         */
        
        public function convertInputToChunks($input)
        {
            // Core Variables
            
            $characters = null;
            
            // Chunk Variables
            
            $chunks = [];
            $byte   = null;
            
            // Logic
            
            $characters = str_split($input);
            
            foreach ($characters as $character)
            {
                // Convert Character To Byte
                
                $byte = ord($character) & 0xFF;
                
                // Split Byte Into Chunks
                
                $chunks[] = ($byte & 0xF0) >> 4;
                $chunks[] = ($byte & 0x0F) >> 0;
            }
            
            return $chunks;
        }
        
        /********************\
        |* DECODING METHODS *|
        \********************/
        
        /**
         * Merges encoding chunks into a single string.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @param array $chunks
         *   Encoding chunks that should be merged.
         * @return string
         *   Merged encoding chunks - actual decoding.
         */
        
        public function mergeEncodingChunks($chunks)
        {
            // Core Variables
            
            $decoding  = "";
            $byte      = null;
            
            // Logic
            
            for ($i = 0; $i < count($chunks); $i += 2)
            {
                $byte = (($chunks[$i] << 4) | $chunks[$i + 1]) & 0xFF;
                
                $decoding .= sprintf("%c", $byte);
            }
            
            return $decoding;
        }
        
        /*****************\
        |* OTHER METHODS *|
        \*****************/
        
        // OTHER METHODS GO HERE
    }
    
?>
