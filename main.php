<html>
    <body>

        <form action="main.php" method="POST">
            String <input type="text" name="string"><br>
            <input type="submit">
        </form>

    </body>
</html>

<?php
// offset all chars of a string by 13 chars
// after second use, string is back to normal
function rot13(string $str_og): string {
    $str_rot13 = ""; // string with rot13 applied

    $A_int = ord("A"); // int value of A
    $a_int = ord("a"); // int value of a
    $Z_int = ord("Z"); // int value of Z
    $z_int = ord("z"); // int value of z

    $AZ_range = $Z_int - $A_int; // range between A and Z
    $az_range = $z_int - $a_int; // range between a and z

    // check encoding
    if($az_range != 25 || $AZ_range != 25){
        die("ERROR: invalid encoding\naz_range = $az_range\nAZ_range = $AZ_range\n");
    }

    // loop through chars in string
    for($i=0; $i < strlen($str_og); $i = $i +1){
        $c = $str_og[$i];
        $c_int = ord($c); // int value of current char

        // check if char is within limits
        if($c_int >= $A_int && $c_int <= $z_int){
            // check if char is lower case
            if($c == strtolower($c)){
                $new_c_int = $c_int + 13; // offset char value by 13

                // check if offset char value is out of range
                if($new_c_int > $z_int){
                    $new_c_int = $a_int + $new_c_int - $z_int - 1; // wrap char value to fit range
                }
            }
            // check if char is upper case
            else if($c == strtoupper($c)){
                $new_c_int = $c_int + 13; // offset char value by 13


                // check if offset char value is out of range
                if($new_c_int > $Z_int){
                    $new_c_int = $A_int + $new_c_int - $Z_int - 1; // wrap char value to fit range
                }
            }
            // catch rest
            else{
                die("ERROR: invalid something\nc = $c\nc_lower = " . strtolower($c) . "\nc_upper = " . strtoupper($c) . "\n");
            }
        }
        // catch out of limits
        else{
            //die("ERROR: invalid range of chars\nc_int = $c_int\n");
            $new_c_int = $c_int; // stays the same
        }

        $str_rot13 = $str_rot13 . chr($new_c_int); // add char to adjusted string
    }

    return $str_rot13; // return adjusted string
}

// DRIVER
function main(): void {
    //$str_og = "Hello World!";
    $str_og = $_POST["string"];

    if($str_og == NULL){
        die("ERROR: str_og is NULL\n");
    }

    $str_rot13 = rot13($str_og);

    print("$str_rot13\n");
}

main(); // call driver
?>

