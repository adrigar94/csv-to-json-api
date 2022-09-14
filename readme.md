# CSV-To-JSON-API

API for transforming CSV files to JSON via HTTP requests

## Background

API for the challenge https://nuwe.io/dev/challenges/csv-to-json

## Usage

Upload a CSV file and return JSON response with data read from CSV.

## API/Component

| Method | Path             | Parameters       |
|--------|------------------|------------------|
| POST   | /csv2json/parser | - csv [csv file] |

## Installation

1. Clone this project
2. Run tests
    - go to project directory
    -   ```shell
        php bin/phpunit
        vendor/bin/behat
        ```
3. Init development server
    - ```shell
        symfony server:ca:install
        symfony server:start
        ```
4. Or install web server for production environment.

## Postman

In the /postman directory you can find the collection containing the API request with its respective tests. To pass the tests, use the file test.csv in the postman directory.

## Stack

- PHP 8.1
- Symfony

## License 

[MIT](https://opensource.org/licenses/MIT)
