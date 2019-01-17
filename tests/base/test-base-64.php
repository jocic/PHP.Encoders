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
    
    use PHPUnit\Framework\TestCase;
    use Jocic\Encoders\Base\Base64;
    
    /**
     * <i>TestBase64</i> class is used for testing method implementation of the
     * class <i>Base64</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2019 All Rights Reserved
     * @version   1.0.0
     */
    
    class TestBase64 extends TestCase
    {
        /*********************\
        |* GET & SET METHODS *|
        \*********************/
        
        /**
         * Tests <i>getBaseTableMethod</i> method for the <i>Base 64</i>
         * implementation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testGetBaseTableMethod()
        {
            // Core Variables
            
            $encoder = new Base64();
            
            // Logic
            
            $this->assertSame([
                "A", "B", "C", "D", "E", "F", "G", "H", "I",
                "J", "K", "L", "M", "N", "O", "P", "Q", "R",
                "S", "T", "U", "V", "W", "X", "Y", "Z", "a",
                "b", "c", "d", "e", "f", "g", "h", "i", "j",
                "k", "l", "m", "n", "o", "p", "q", "r", "s",
                "t", "u", "v", "w", "x", "y", "z", "0", "1",
                "2", "3", "4", "5", "6", "7", "8", "9", "+",
                "/"
            ], $encoder->getBaseTable());
        }
        
        /**
         * Tests <i>getBasePadding</i> method for the <i>Base 64</i>
         * implementation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testGetBasePaddingMethod()
        {
            // Core Variables
            
            $encoder = new Base64();
            
            // Logic
            
            $this->assertSame("=", $encoder->getBasePadding());
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Tests encoding validation for the <i>Base 64</i> implementation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testValidation()
        {
            // Core Variables
            
            $encoder = new Base64();
            
            // Other Variables
            
            $testValues = [
                ""         => true,
                "Zg=="     => true,
                "Zm9vYg==" => true,
                "&43"      => false,
                "==T~R==f" => false,
                "Uf9@4FER" => false
            ];
            
            // Step 1 - Test Valid Values
            
            foreach ($testValues as $testValue => $testResult)
            {
                $this->assertSame($testResult,
                    $encoder->isEncodingValid($testValue), $testValue);
            }
        }
        
        /*******************\
        |* PRIMARY METHODS *|
        \*******************/
        
        /**
         * Tests encoding process of the <i>Base 64</i> implementation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testEncodingProcesses()
        {
            // Core Variables
            
            $encoder = new Base64();
            
            // Step 1 - Apply Padding
            
            $this->assertSame("Zg==", $encoder->applyPadding("Zg"));
            
            try
            {
                $encoder->applyPadding("#");
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid encoding provided, padding" .
                    " can't be applied. Encoding: \"#\"", $e->getMessage());
            }
            
            // Step 2 - Chunk Conversion
            
            $this->assertSame([
                25, 38, 61, 47
            ], $encoder->convertInputToChunks("foo"));
        }
        
        /**
         * Tests decoding process of the <i>Base 64</i> implementation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testDecodingProcesses()
        {
            // Core Variables
            
            $encoder = new Base64();
            
            // Step 1 - Strip Padding
            
            $this->assertSame("Zg", $encoder->stripPadding("Zg=="));
            
            try
            {
                $encoder->stripPadding("#");
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid encoding provided, padding" .
                    " can't be stripped. Encoding: \"#\"", $e->getMessage());
            }
            
            // Step 2 - Chunk Conversion
            
            $this->assertSame([
                25, 32
            ], $encoder->convertEncodingToChunks("Zg=="));
            
            try
            {
                $encoder->convertEncodingToChunks("#");
                
                $this->fail("Exception should've been thrown!");
            }
            catch (\Exception $e)
            {
                $this->assertEquals("Invalid encoding provided, it " .
                    "can't be converted. Encoding: \"#\"", $e->getMessage());
            }
        }
        
        /*********************\
        |* SECONDARY METHODS *|
        \*********************/
        
        /**
         * Tests encoding of the <i>Base 32</i> implementation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testEncoding()
        {
            // Core Variables
            
            $encoder = new Base64();
            
            // Logic.
            
            $this->assertSame("", $encoder->encode(""));
            $this->assertSame("Zg==", $encoder->encode("f"));
            $this->assertSame("Zm8=", $encoder->encode("fo"));
            $this->assertSame("Zm9v", $encoder->encode("foo"));
            $this->assertSame("Zm9vYg==", $encoder->encode("foob"));
            $this->assertSame("Zm9vYmE=", $encoder->encode("fooba"));
            $this->assertSame("Zm9vYmFy", $encoder->encode("foobar"));
            $this->assertSame("Zm9vYmFyMQ==", $encoder->encode("foobar1"));
            $this->assertSame("Zm9vYmFyMTI=", $encoder->encode("foobar12"));
            $this->assertSame("Zm9vYmFyMTIz", $encoder->encode("foobar123"));
        }
        
        /**
         * Tests decoding of the <i>Base 64</i> implementation.
         * 
         * @author    Djordje Jocic <office@djordjejocic.com>
         * @copyright 2019 All Rights Reserved
         * @version   1.0.0
         * 
         * @return void
         */
        
        public function testDecoding()
        {
            // Core Variables
            
            $encoder = new Base64();
            
            // Logic
            
            $this->assertSame("", $encoder->decode(""));
            $this->assertSame("f", $encoder->decode("Zg=="));
            $this->assertSame("fo", $encoder->decode("Zm8="));
            $this->assertSame("foo", $encoder->decode("Zm9v"));
            $this->assertSame("foob", $encoder->decode("Zm9vYg=="));
            $this->assertSame("fooba", $encoder->decode("Zm9vYmE="));
            $this->assertSame("foobar", $encoder->decode("Zm9vYmFy"));
            $this->assertSame("foobar1", $encoder->decode("Zm9vYmFyMQ=="));
            $this->assertSame("foobar12", $encoder->decode("Zm9vYmFyMTI="));
            $this->assertSame("foobar123", $encoder->decode("Zm9vYmFyMTIz"));
        }
    }
    
?>
