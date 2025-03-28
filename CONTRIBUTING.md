# Contributing

Contributions are welcome, and are accepted via pull requests. Please review these guidelines before submitting any pull
requests.

## Guidelines

* Please follow
  the [PSR-12 Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-12-extended-coding-style-guide.md).
* Ensure that the current tests pass, and if you've added something new, add the tests where relevant.
* Remember that we follow [SemVer](http://semver.org). If you are changing the behavior, or the public api, you may
  need to update the docs.
* Send a coherent commit history, making sure each individual commit in your pull request is meaningful. If you have to
  make multiple intermediate commits while developing,
  please [squash](http://git-scm.com/book/en/Git-Tools-Rewriting-History) them before submitting.
* You may also need to [rebase](http://git-scm.com/book/en/Git-Branching-Rebasing) to avoid merge conflicts.

## Running Tests

You will need an installation of [Composer](https://getcomposer.org) before continuing.

First, install the dependencies:

```bash
$ composer install
```

Then run the test script:

```bash
$ composer test
```

If the test suite passes on your local machine, you should be good to go.

When you make a pull request, the tests will automatically be run again
by [GitHub Actions](https://github.com/speniti/filament-mapbox/actions/).

## Before Pushing

Please run the following scripts to lint the code before pushing it.

Lint PHP files with Composer:

```bash
composer lint
```

Lint TypeScript and CSS files with NPM:

```bash
npm run lint
```

When you make a pull request, the lint scripts will automatically be run again
by [GitHub Actions](https://github.com/speniti/filament-mapbox/actions/).
