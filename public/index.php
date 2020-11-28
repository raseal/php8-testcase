<?php

// ******************
// Named arguments
// Nice! We can inject only the required params in any order!
// ******************
function test_named_arguments(
    string $required,
    string $another_required,
    string $optional = "default value"
): void {
    echo "<p>required: $required <br/> another_required: $another_required <br/> optional: $optional</p>";
}

test_named_arguments(
    another_required: "23",
    required: "w",
);


// ******************
// Attributes
// Skipped! I don't like annotations :)
// ******************


// ******************
// Constructor Property Promotion
// I understand the advantages but I still prefer having the attributes at the beginning of my classes.
// ******************
class User
{
    public function __construct(
        private string $id,
        private string $name,
        private string $email,
    ) {}
}

$user = new User('some-UUID-here', 'username', 'mail@address.org');
print_r($user);


// ******************
// Union types
// Actually I am not sure if I like the union types
// ******************
class UnionTypeTest
{
    public function __construct(
        private int|float $field
    ) {}
}

new UnionTypeTest(1);
new UnionTypeTest(1.0);
new UnionTypeTest("12"); // PHP8 casts "12" to int :)
new UnionTypeTest(true); // PHP8 casts true to int :)

try {
    new UnionTypeTest("value");
} catch (Throwable $e) {
    echo "<p> PHP8 crashes since 'value' cannot be converted to number!</p>";
}


// ******************
// Match expression
// It seems a more compact switch, but with only one instruction per index. Nice!
// ******************
$result = match (1) {
    '1' => 'One string',
    true => 'A boolean',
    1 => 'One number',
    1 => 'Unreachable line',
};

print_r($result); // prints "One number"


// ******************
// Nullsafe operator
// I don't like the Nullsafe operator, I think this can create inconsistences in the code
// ******************
class NullsafeTest
{
    public function __construct(
        private string $email,
    ) {}

    public function email(): string
    {
        return $this->email;
    }
}

$user_with_email = new NullsafeTest('email@address.com');
echo '<p>' . $user_with_email->email() . '</p>';

$inexistent_user = null;
$inexistent_user?->email(); // This no longer throws an error


// ******************
// String to number comparison
// Nice!
// ******************
assert(0 == '0', 'PHP still converts numbers to string :(');
assert(1 == true, 'PHP still converts booleans to number :(');
assert(0 == null, 'It still annoys me, an int should not be compared as a NULL :(');
assert(0 != 'random string', 'PHP now evaluates this as FALSE! :DD');


// ******************
// No need to capture the catches
// Very useful!!
// ******************

try {
    throw new Exception('Manually triggered exception!');
} catch( Exception) {
    echo '<p>Now it is not necessary to pass the "$e" variable to the catch()!</p>';
}


// ******************
// Throw expression
// I really love this feature :))
// ******************
try {
    $value = $inexistent_var ?? throw new InvalidArgumentException();
} catch (InvalidArgumentException) {
    echo "<p>Now, the 'throw' can be used whenever an expression is allowed!</p>";
}

try {
    $doable = (15/0) ? true : throw new DivisionByZeroError();
} catch (DivisionByZeroError) {
    echo "<p>The 'throw' works also in a ternary operator!</p>";
}

try {
    match (false) {
        true => 'It works!',
        false => throw new Exception(),
    };
} catch (Exception) {
    echo "<p>It still works on the new 'match' feature</p>";
}


// ******************
// ::class on objects
// Self-explanatory
// ******************

echo "<p>" . Stdclass::class . "</p>";

$object = new Stdclass();
echo "<p>" . $object::class . "</p>";


// ******************
// Weakmaps
// I've seen this before, very useful
// ******************
$map = new WeakMap;
$key = new Stdclass;

$map[$key] = 'First value for the map';

print_r($map); // It shows our map with only one value

unset($key);

print_r($map); // The "key" is removed from the map, along with his assigned value


// ******************
// Stringable interface
// It was about time
// ******************

class Number implements Stringable
{
    public function __construct(
        private int $number,
    ) {}

    public function __toString(): string
    {
        return (string) $this->number;
    }
}

$number = new Number(15);
echo "<p>" . $number. "</p>";


// ******************
// New string functions
// Sayônara, stripos !== false
// ******************
$haystack = "Doctor Who";
$needle = "exterminate";

if (str_contains($haystack, $needle)) {
    echo "<p>Dalek wins!</p>";
}

$haystack = "Doctor House";
$needle = 'house';

if (str_contains($haystack, $needle)) {
    echo "<p>This function is case-sensitive</p>";
}

//There are two more functions:
// - https://www.php.net/manual/en/function.str-starts-with.php
// - https://www.php.net/manual/en/function.str-ends-with.php
