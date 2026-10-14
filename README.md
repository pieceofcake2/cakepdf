# CakePdf plugin

[![GitHub License](https://img.shields.io/github/license/pieceofcake2/cakepdf?label=License)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/pieceofcake2/cakepdf?label=Packagist)](https://packagist.org/packages/pieceofcake2/cakepdf)
![PHP](https://img.shields.io/packagist/dependency-v/pieceofcake2/cakepdf/php?logo=php&logoColor=%23FFFFFF&label=PHP&labelColor=%23777BB4&color=%23FFFFFF)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%205-brightgreen?label=PHPStan)](https://github.com/pieceofcake2/cakepdf/actions/workflows/CI.yml)
![CakePHP](https://img.shields.io/packagist/dependency-v/pieceofcake2/cakepdf/pieceofcake2/cakephp?logo=cakephp&logoColor=%23FFFFFF&label=CakePHP&labelColor=%23D33C43&color=%23FFFFFF)
[![CI](https://img.shields.io/github/actions/workflow/status/pieceofcake2/cakepdf/CI.yml?label=CI)](https://github.com/pieceofcake2/cakepdf/actions/workflows/CI.yml)
[![Codecov](https://img.shields.io/codecov/c/gh/pieceofcake2/cakepdf?label=Coverage)](https://codecov.io/gh/pieceofcake2/cakepdf)

CakePdf converts HTML to PDF with Dompdf, mPDF, TCPDF or wkhtmltopdf. It renders controller
actions as PDF with `PdfView` and creates PDF files for email attachments or file storage.
This is a fork of [FriendsOfCake/CakePdf](https://github.com/FriendsOfCake/CakePdf) 1.x for
[pieceofcake2/cakephp](https://github.com/pieceofcake2/cakephp).

## Requirements

* PHP 8.0+
* pieceofcake2/cakephp 2.12+
* One of dompdf/dompdf, mpdf/mpdf, tecnickcom/tcpdf or the [wkhtmltopdf](https://wkhtmltopdf.org/) binary
* [pdftk](https://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/) (optional, for encryption)

## Installation

```
composer require pieceofcake2/cakepdf
```

## Documentation

See the [documentation](https://pieceofcake2.github.io/cakepdf/).

## Contributing

See the [contribution guidelines](https://github.com/pieceofcake2/.github/blob/master/CONTRIBUTING.md).

## License

The MIT License. See [LICENSE](LICENSE).
