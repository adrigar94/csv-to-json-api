Feature: Status control
    Scenario: Check if status is ok
        Given I am a unauthenticated client
        When I request a check status from "http://127.0.0.1:8000/status"
        Then The result should include a success True