<?php
/**
 * luhnModN
 *
 * This class generates random checksummed strings to be used for unqiue link generation.  The alphabet omits confusing characters (like l and 1)
 * and vowels to prevent accidental profanity/word generation.  This class is not wired up for batch generation or uniquing.  
 *
 */

class luhnModN{

    protected $alphaLength;
    protected $factor = 2;
    
    /*************************
     User adjustable settings
    **************************/
    
    // alphabet used for code generation
    protected $alphabet = 'bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ23456789';
    // length of finished code, including checksum character
    protected $codeLength = 10;
    // number of characters used to calculate the checksum
    protected $checksumCalcChars = 9;



    public function __construct(){
        $this->alphaLength = mb_strlen($this->alphabet);
    }

    public function getLinkString(){
        return $this->generateString();
    }

	/**
     * @param $code
     * @return bool
     */
    public function validateChecksum($code){
        // if the code isn't the right length, it's not valid
        if(!isset($code{$this->codeLength-1})){
            return false;
        }
        $checkSum = $this->generateCheckSum($this->removeChecksum($code));
        $checkCode = $this->attachChecksum($this->removeChecksum($code),$checkSum);

        if($checkCode === $code){
            return true;
        }else{
            return false;
        }

    }
    
    protected function generateString(){
        $code = "";

        // leave space for the checksum
        $length = $this->codeLength - 1;

        //checking the string key is faster than checking string length
        while(!isset($code{$length-1})){
            $code.=$this->alphabet{mt_rand(0,$this->alphaLength - 1)};
        }

        $code = $this->attachChecksum($code,$this->generateCheckSum($code));


        return $code;
    }


    /**
     * @param $code
     * @return string
     */
    protected function generateCheckSum($code){
        $sum = 0;
        $codeLen = mb_strlen($code);
        $curFactor = $this->factor;

        for($i = $codeLen-1;$i>=($codeLen-$this->checksumCalcChars);$i--){
            $num = $i;
            $codePoint = strpos($this->alphabet, $code{$num});
            $addend = $curFactor * $codePoint;

            //alternate the factor that each point is multiplied by
            $curFactor = ($curFactor == $this->factor) ? 1 : $this->factor;

            $addend = ($addend/$this->alphaLength) + ($addend%$this->alphaLength);
            $sum += $addend;
        }

        $remainder = $sum%$this->alphaLength;
        $checkCodePoint = ($this->alphaLength-$remainder)%$this->alphaLength;

        return $this->alphabet{$checkCodePoint};
    }

    /**
     * @param $code
     * @param $checksum
     * @return string
     */
    protected function attachChecksum($code,$checksum){
        return $code.$checksum;
    }

    /**
     * @param $code
     * @return string
     */
    protected function removeChecksum($code){
        return substr($code,0,-1);
    }
}