luhn-mod-n
==========

This is a simple PHP class that implements the Luhn Mod N algorithm and generates random checksummed codes for use in custom link generation and the like.  
The alphabet omits confusing characters (like l and 1) and vowels to prevent accidental profanity/word generation.

** The following public methods are provided:

luhnModN::__construct()
Performs alphabet length calculation
	
luhnModN::getLinkString()
Returns a checksummed code per the class configuration
	
luhnModN::validateChecksum($code)
Takes a code (string) as a parameter and returns a bool to determine if this code passes checksum validation.
This is particularly useful to avoid a hit to a data store or such, as if the checksum isn't valid the code can not possibly be valid.


** The following private methods exist:

luhnModN::generateString()
Provides the logic for string generation
	
luhnModN::generateCheckSum($code)
Called by generateString to perform necessary checksum calculations, returns checksum character
	
luhnModN::attachChecksum($code,$checksum)
Used by generateString to attach the checksum to the code.  This helper method is useful in the event you want to change where the checksum is placed.
By default the checksum is appended to the code.
	
luhnModN::removeChecksum($code)
Does exactly what you think.  Removes the checksum.  This is utilized when validating a code





	
