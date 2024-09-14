# PHP Database Class

This PHP Database class provides a simple and efficient way to interact with MySQL databases using PDO. It offers methods for common database operations such as querying, inserting, updating, and fetching data.

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
- [Methods](#methods)
- [Examples](#examples)

## Installation

1. Download the `db.php` file and include it in your project.
2. Use the class in your PHP scripts by including it:

```php
require_once 'path/to/db.php';
```

## Usage

To use the Database class, first create an instance by providing your database connection details:

```php
$db = new Database('localhost', 'your_database', 'username', 'password');
```

## Methods

### query($sql, $params = [])
Prepares and executes an SQL query with optional parameters.

### fetchAll()
Fetches all rows from the result set.

### fetch()
Fetches a single row from the result set.

### rowCount()
Returns the number of rows affected by the last SQL statement.

### lastInsertId()
Returns the ID of the last inserted row.

### insert($table, $data)
Inserts a new row into the specified table.

### update($table, $data, $where)
Updates rows in the specified table that match the given conditions.

### close()
Closes the database connection.

## Examples

### Querying Data
```php
$results = $db->query("SELECT * FROM users WHERE age > ?", [18])->fetchAll();
```

### Inserting Data
```php
$userId = $db->insert('users', [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'age' => 30
]);
```

### Updating Data
```php
$affected = $db->update('users', 
    ['name' => 'Jane Doe', 'age' => 31], 
    ['id' => 1]
);
```

### Fetching a Single Row
```php
$user = $db->query("SELECT * FROM users WHERE id = ?", [1])->fetch();
```

### Counting Rows
```php
$count = $db->query("SELECT COUNT(*) FROM users")->fetch();
```

Remember to close the database connection when you're done:

```php
$db->close();
```

## Error Handling

The class uses PDO's exception mode. Wrap your database operations in try-catch blocks to handle any potential errors:

```php
try {
    // Your database operations here
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Contributing

Feel free to submit pull requests or open issues to improve this class.

## License

This Database class is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
