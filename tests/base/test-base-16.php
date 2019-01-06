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
    use Jocic\Encoders\Base\Base16;
    
    /**
     * <i>TestBase16</i> class is used for testing method implementation of the
     * class <i>Base16</i>.
     * 
     * @author    Djordje Jocic <office@djordjejocic.com>
     * @copyright 2019 All Rights Reserved
     * @version   1.0.0
     */
    
    class TestBase16 extends TestCase
    {
        /*********************\
        |* GET & SET METHODS *|
        \*********************/
        
        /**
         * Tests <i>getBaseTableMethod</i> method for the <i>Base 16</i>
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
            
            $encoder = new Base16();
            
            // Logic
            
            $this->assertSame([
                "0", "1", "2", "3", "4", "5", "6", "7",
                "8", "9", "A", "B", "C", "D", "E", "F"
            ], $encoder->getBaseTable());
        }
        
        /**
         * Tests <i>getBasePadding</i> method for the <i>Base 16</i>
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
            
            $encoder = new Base16();
            
            // Logic
            
            $this->assertSame("", $encoder->getBasePadding());
        }
        
        /*****************\
        |* CHECK METHODS *|
        \*****************/
        
        /**
         * Tests encoding validation for the <i>Base 16</i> implementation.
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
            
            $encoder = new Base16();
            
            // Other Variables
            
            $testValues = [
                ""       => true,
                "66"     => true,
                "666F6F" => true,
                "&43"    => false,
                "=TeR=#" => false,
                "Uf934d" => false
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
         * Tests encoding process of the <i>Base 16</i> implementation.
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
            
            $encoder = new Base16();
            
            // Logic
            
            $this->assertSame([
                6, 6, 6, 15, 6, 15
            ], $encoder->convertInputToChunks("foo"));
        }
        
        /**
         * Tests decoding process of the <i>Base 16</i> implementation.
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
            
            $encoder = new Base16();
            
            // Step 2 - Chunk Conversion
            
            $this->assertSame([
                6, 6, 6, 15, 6, 15
            ], $encoder->convertEncodingToChunks("666F6F"));
            
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
         * Tests encoding of the <i>Base 16</i> implementation.
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
            
            $encoder = new Base16();
            
            // Logic.
            
            $this->assertSame("", $encoder->encode(""));
            $this->assertSame("66", $encoder->encode("f"));
            $this->assertSame("666F", $encoder->encode("fo"));
            $this->assertSame("666F6F", $encoder->encode("foo"));
            $this->assertSame("666F6F62", $encoder->encode("foob"));
            $this->assertSame("666F6F6261", $encoder->encode("fooba"));
            $this->assertSame("666F6F626172", $encoder->encode("foobar"));
            $this->assertSame("666F6F62617231", $encoder->encode("foobar1"));
            $this->assertSame("666F6F6261723132", $encoder->encode("foobar12"));
            $this->assertSame("666F6F626172313233", $encoder->encode("foobar123"));
        }
        
        /**
         * Tests decoding of the <i>Base 16</i> implementation.
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
            
            $encoder = new Base16();
            
            // Logic
            
            $this->assertSame("", $encoder->decode(""));
            $this->assertSame("f", $encoder->decode("66"));
            $this->assertSame("fo", $encoder->decode("666F"));
            $this->assertSame("foo", $encoder->decode("666F6F"));
            $this->assertSame("foob", $encoder->decode("666F6F62"));
            $this->assertSame("fooba", $encoder->decode("666F6F6261"));
            $this->assertSame("foobar", $encoder->decode("666F6F626172"));
            $this->assertSame("foobar1", $encoder->decode("666F6F62617231"));
            $this->assertSame("foobar12", $encoder->decode("666F6F6261723132"));
            $this->assertSame("foobar123", $encoder->decode("666F6F626172313233"));
        }
    }
    
?>
