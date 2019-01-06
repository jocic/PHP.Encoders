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
    use Jocic\Encoders\Base\Base32;
    
    /**
     * <i>TestBase32</i> class is used for testing method implementation of the
     * class <i>Base32</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2019 All Rights Reserved
     * @version   1.0.0
     */
    
    class TestBase32 extends TestCase
    {
        /*********************\
        |* GET & SET METHODS *|
        \*********************/
        
        /**
         * Tests <i>getBaseTableMethod</i> method for the <i>Base 32</i>
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
            
            $encoder = new Base32();
            
            // Logic
            
            $this->assertSame([
                "A", "B", "C", "D", "E", "F", "G", "H", "I",
                "J", "K", "L", "M", "N", "O", "P", "Q", "R",
                "S", "T", "U", "V", "W", "X", "Y", "Z", "2",
                "3", "4", "5", "6", "7"
            ], $encoder->getBaseTable());
        }
        
        /**
         * Tests <i>getBasePadding</i> method for the <i>Base 32</i>
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
            
            $encoder = new Base32();
            
            // Logic
            
            $this->assertSame("=", $encoder->getBasePadding());
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Tests encoding validation for the <i>Base 32</i> implementation.
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
            
            $encoder = new Base32();
            
            // Other Variables
            
            $testValues = [
                ""         => true,
                "MY======" => true,
                "MZXW6YTB" => true,
                "&43"      => false,
                "==TeR==f" => false,
                "Uf934FER" => false
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
         * Tests encoding process of the <i>Base 32</i> implementation.
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
            
            $encoder = new Base32();
            
            // Step 1 - Apply Padding
            
            $this->assertSame("MY======", $encoder->applyPadding("MY"));
            
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
                12, 25, 23, 22, 30
            ], $encoder->convertInputToChunks("foo"));
        }
        
        /**
         * Tests decoding process of the <i>Base 32</i> implementation.
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
            
            $encoder = new Base32();
            
            // Step 1 - Strip Padding
            
            $this->assertSame("MY", $encoder->stripPadding("MY======"));
            
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
                12, 24
            ], $encoder->convertEncodingToChunks("MY======"));
            
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
            
            $encoder = new Base32();
            
            // Logic.
            
            $this->assertSame("", $encoder->encode(""));
            $this->assertSame("MY======", $encoder->encode("f"));
            $this->assertSame("MZXQ====", $encoder->encode("fo"));
            $this->assertSame("MZXW6===", $encoder->encode("foo"));
            $this->assertSame("MZXW6YQ=", $encoder->encode("foob"));
            $this->assertSame("MZXW6YTB", $encoder->encode("fooba"));
            $this->assertSame("MZXW6YTBOI======", $encoder->encode("foobar"));
            $this->assertSame("MZXW6YTBOIYQ====", $encoder->encode("foobar1"));
            $this->assertSame("MZXW6YTBOIYTE===", $encoder->encode("foobar12"));
            $this->assertSame("MZXW6YTBOIYTEMY=", $encoder->encode("foobar123"));
        }
        
        /**
         * Tests decoding of the <i>Base 32</i> implementation.
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
            
            $encoder = new Base32();
            
            // Logic
            
            $this->assertSame("", $encoder->decode(""));
            $this->assertSame("f", $encoder->decode("MY======"));
            $this->assertSame("fo", $encoder->decode("MZXQ===="));
            $this->assertSame("foo", $encoder->decode("MZXW6==="));
            $this->assertSame("foob", $encoder->decode("MZXW6YQ="));
            $this->assertSame("fooba", $encoder->decode("MZXW6YTB"));
            $this->assertSame("foobar", $encoder->decode("MZXW6YTBOI======"));
            $this->assertSame("foobar1", $encoder->decode("MZXW6YTBOIYQ===="));
            $this->assertSame("foobar12", $encoder->decode("MZXW6YTBOIYTE==="));
            $this->assertSame("foobar123", $encoder->decode("MZXW6YTBOIYTEMY="));
        }
    }
    
?>
