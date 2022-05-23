This coding exercise forms the technical part of our interview process at TestCard.

This repository is a fresh clean installation of Laravel 8 framework - please either create a private fork of it or
create a new empty repository if you prefer, and make changes according to the brief below.

# Brief

Here at TestCard, we’ve created a new test to detect a fictional infection - Talvitis.

Our scientists want to be able to send test samples to an algorithm for analysis and then be able to view the responses
in a dashboard. Your task is to create a portal that would enable them to do that, using a Laravel and Vue.

The portal should not be publicly accessible, it should have an authentication mechanism in place. The below
instructions outline the base requirements for the end system. You are free to make decisions about the product, and the
implementation where it has not been specified, but please do make a note of any assumptions you have made.

## The Back-end

You need to design a simple API that would allow the application to:

* Upload an image of a test strip
* List all tests uploaded

When the system receives an image of a test strip, it should send it to the provided analysis server to be analyzed.
Since TestCard is a rapidly growing company, we constantly release new products, and you should take into account that
other products might use different analysis services. Also, you should ensure that the system is bulletproof as there is
no room for errors in the MedTech industry.

When the system lists out all tests uploaded, the data should be paginated and include the test id, image of the test
strip, user that uploaded the test, and the analysis results where available. The analysis results should include the
outcome/result of the test (e.g. Positive, Negative, Invalid) and the readings as provided by the analysis server.

### Authentication

Please make sure that only authorized users can access the API and the portal. Please feel free to choose what
authentication mechanism you want to use. It might be helpful to think about your front-end implementation as you decide
how you want to authenticate your users.

The users need the ability to be able to provide their email address and password to gain access to the portal. No
registration functionality needed.

### Analysis Server

The analysis server has an endpoint that performs test analysis on a given image. The endpoint URL is:

```
https://bwsho71wt6.execute-api.eu-west-2.amazonaws.com/api/tests/analyse/{test_id}
```

`{test_id}` URL parameter can be any integer ID of a test record (for the code test purposes the endpoint will return
deterministic analysis results based on the test id provided).

To submit an image for analysis, you should make a `POST` request to the endpoint with the following input:

- `image` (required) (file) the image of the test cartridge
- `test_type` (required) (string) which type of test you're trying to perform, in this case it would be `talvitis`

You can authenticate your requests using this Bearer Token:

```
xqvzfFppKgFZ3LU8iKbCngOpBdRW2D2d
```

## The Front-end

You need to create a simple portal where the users will be able to login and use functionality of the system (upload and
view tests). Please note that your design skills are not being evaluated here, feel free to keep it as simple as you
want as long as it is easy to understand and use.

You are free to choose how you want to implement this portal - you may want to do a VueJs Single-Page Application that
directly consumes your designed API, a Laravel views based portal or something in between (e.g. Laravel Jetstream).

The portal needs to have a login page where the user can enter their email address and password to gain access to the
portal. Once logged in, the user should be able to view all tests performed in a paginated list as well as upload a new
test.

# Submission

Please make any notes or comments about your approach and implementation in this README file (optional) and submit your
repository. You can submit your repository by either putting it into a `zip` archive or granting us access to your
private fork.

Please grant access to, as well as direct any questions to *talvinder@testcard.com*.
