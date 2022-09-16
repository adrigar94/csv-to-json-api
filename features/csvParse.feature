Feature: CSV parse
    Scenario: Check if CSV is parsed
        Given I have a CSV file "test.csv"
        When I request a parse CSV file from "http://127.0.0.1:8000/csv2json/parser"
        Then The result is a success JSON response
        And The result is a CSV parsed same a "test_parsed.json"
    Scenario: Check if return error when CSV is missing
        Given I don't have a CSV file
        When I request a parse CSV file from "http://127.0.0.1:8000/csv2json/parser"
        Then The result is a error JSON response