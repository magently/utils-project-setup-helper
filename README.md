# Magently Utils Project Setup Helper

## !! Don't use this package on production environment !!

## Installing package

To install the package, use composer:
`composer require --dev magently/utils-project-setup-helper`

After configuring a project, we suggest to remove the package from the project:
`composer remove magently/utils-project-setup-helper`

## Running commands

From Magento root path, execute `./vendor/bin/configure` to see available commands and help message

## Contribute

If you want to add your own command:
- register the command in the `src/config.php` file
- create a class that implements the `\Magently\UtilsProjectSetupHelper\Command\CommandInterface` interface
- create a pull request
