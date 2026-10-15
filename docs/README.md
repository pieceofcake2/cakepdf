# CakePdf Documentation

CakePdf converts HTML to PDF with a PDF engine. It renders controller actions as PDF
with `PdfView` and creates PDF files for email attachments, file storage and more.

Supported engines:

* Dompdf
* mPDF
* TCPDF
* wkhtmltopdf (requires the `wkhtmltopdf` binary)

See [Engines and Licenses](#engines-and-licenses) for links, licenses and notes on each
engine.

- [Installation](#installation)
- [Engines and Licenses](#engines-and-licenses)
- [Configuration](#configuration)
- [Usage](#usage)
- [Encryption](#encryption)
- [Static Assets](#static-assets)
- [Thanks](#thanks)

## Installation

Install the plugin with [Composer](https://getcomposer.org/):

```bash
composer require pieceofcake2/cakepdf
```

The plugin has the `cakephp-plugin` type, so it is installed into your plugins directory
(as `CakePdf`) by `composer/installers`. Set `installer-paths` in your application's
`composer.json` so it is installed into the right place:

| Layout | `installer-paths` |
| --- | --- |
| Modern (`config/`, `src/`, `templates/`, `plugins/`) | `"plugins/{$name}/": ["type:cakephp-plugin"]` |
| Legacy (`app/Config/`, `app/Plugin/`) | `"app/Plugin/{$name}/": ["type:cakephp-plugin"]` |

Install the library of the engine you use:

| Engine | Requirement |
| --- | --- |
| `CakePdf.DomPdf` | `composer require dompdf/dompdf` |
| `CakePdf.Mpdf` | `composer require mpdf/mpdf` |
| `CakePdf.Tcpdf` | `composer require tecnickcom/tcpdf` |
| `CakePdf.WkHtmlToPdf` | the [wkhtmltopdf](https://wkhtmltopdf.org/) binary |

Encryption additionally requires the [pdftk](https://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/)
binary.

### Enable the plugin

Load the plugin with its bootstrap and routes in `config/bootstrap.php` (legacy layout:
`app/Config/bootstrap.php`):

```php
CakePlugin::load('CakePdf', ['bootstrap' => true, 'routes' => true]);
```

The routes enable the `.pdf` extension.

## Engines and Licenses

CakePdf itself is released under the MIT License, but every engine is a separate project
with its own license. You install the engine library (or binary) yourself, so its license
applies to your application in addition to CakePdf's.

| Engine | Library | Composer package | License | Type | Notes |
| --- | --- | --- | --- | --- | --- |
| `CakePdf.DomPdf` | [Dompdf](https://dompdf.github.io/) ([GitHub](https://github.com/dompdf/dompdf)) | [`dompdf/dompdf`](https://packagist.org/packages/dompdf/dompdf) `^3.1` | [LGPL-2.1](https://github.com/dompdf/dompdf/blob/master/LICENSE.LGPL) | PHP library | PHP `^7.1 \|\| ^8.0`. Mostly CSS 2.1 with a few CSS3 properties; no flexbox or grid, and a table row must fit on one page. Bundles the DejaVu fonts. |
| `CakePdf.Mpdf` | [mPDF](https://mpdf.github.io/) ([GitHub](https://github.com/mpdf/mpdf)) | [`mpdf/mpdf`](https://packagist.org/packages/mpdf/mpdf) `^8.0` | [GPL-2.0-only](https://github.com/mpdf/mpdf/blob/development/LICENSE.txt) | PHP library | PHP 5.6 to 8.5 (8.5 since mPDF 8.2.6). Strong copyleft, see below. Bundles Unicode and CJK fonts. |
| `CakePdf.Tcpdf` | [TCPDF](https://tcpdf.org/) ([GitHub](https://github.com/tecnickcom/TCPDF)) | [`tecnickcom/tcpdf`](https://packagist.org/packages/tecnickcom/tcpdf) `^6.10` | [LGPL-3.0-or-later](https://github.com/tecnickcom/TCPDF/blob/main/LICENSE.TXT) | PHP library | TCPDF 6.x requires PHP 7.1+. Upstream marks TCPDF as deprecated and maintenance-only; development has moved to [tc-lib-pdf](https://github.com/tecnickcom/tc-lib-pdf). TCPDF 7.x (PHP 8.2+) is a compatibility layer over tc-lib-pdf and is not tested with CakePdf. `writeHTML()` supports a limited set of HTML tags and needs well-formed HTML. |
| `CakePdf.WkHtmlToPdf` | [wkhtmltopdf](https://wkhtmltopdf.org/) ([GitHub](https://github.com/wkhtmltopdf/wkhtmltopdf)) | none (system binary) | [LGPL-3.0-or-later](https://github.com/wkhtmltopdf/wkhtmltopdf/blob/master/LICENSE) | External binary | **Unmaintained**: the GitHub repository is archived and the last release is 0.12.6 (June 2020). Renders with an old Qt WebKit, see the [project status](https://wkhtmltopdf.org/status.html). Upstream warns not to use it with untrusted HTML. Uses the fonts installed on the host. |

The versions are the ones CakePdf installs for development (`require-dev` in its
`composer.json`). CakePdf does not restrict the engine versions you install.

The optional [pdftk](https://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/) binary used for
[encryption](#encryption) is an external program as well. PDFtk Server is available under the
[GPL version 2](https://www.pdflabs.com/docs/pdftk-license/) or a commercial redistribution
license, and the [pdftk-java](https://gitlab.com/pdftk-java/pdftk) port is licensed under the
GPL version 2 or later.

### What the license types mean

The following is a short, general summary, not legal advice. The license file of each
project is authoritative; read it, and ask a lawyer when you are unsure how it applies to
your application.

* **Permissive licenses** (MIT, BSD, Apache-2.0), such as CakePdf's own MIT License, allow
  use in open source and proprietary applications. You mainly need to keep the copyright and
  license notices when you distribute the code. None of the engines above uses a permissive
  license.
* **Weak copyleft** (LGPL: Dompdf, TCPDF, wkhtmltopdf) lets you use the library from code
  under any license. When you distribute the library, you must provide its license and
  source, keep any modifications you make to the library itself under the LGPL, and let
  users replace the library with another version. A PHP library installed through Composer
  stays a separate, replaceable component under `vendor/`, and an external binary such as
  wkhtmltopdf is a separate program.
* **Strong copyleft** (GPL: mPDF, pdftk). mPDF's `composer.json` declares `GPL-2.0-only`, and
  its repository ships the GPL version 2 text (the license page of the mPDF manual says
  "version 2 or later", so check the files of the version you install). When you distribute an application that
  includes mPDF, for example by shipping it to customers or as a downloadable product, the
  GPL can require the application to be distributed under GPL-compatible terms with its
  source code. Running a separate program such as pdftk is generally treated differently
  from including a library in your code.
* **SaaS use and distribution.** The obligations of the GPL and LGPL versions listed here
  are triggered by distributing the software (conveying it, in GPLv3/LGPLv3 terms). Running
  them only on your own server to serve users over a network is generally not
  distribution. None of these engines uses the AGPL, which adds obligations for network use.
  Giving your application to a customer to run on their own servers is distribution.

### Japanese text (CJK)

The standard PDF fonts do not contain Japanese characters, so every engine needs a font with
CJK glyphs:

* **Dompdf**: the bundled DejaVu fonts do not cover Japanese. Provide a Japanese TrueType
  font (for example Noto Sans JP) through a CSS `@font-face` rule and use it in
  `font-family`. See [About Fonts and Character Encoding](https://github.com/dompdf/dompdf/wiki/About-Fonts-and-Character-Encoding).
* **mPDF**: ships the `Sun-ExtA` and `Sun-ExtB` fonts, which cover CJK. Use them with
  `font-family: sun-exta;` in your CSS. Fonts that are not embedded (such as Adobe CJK
  fonts) need the [Asian font pack](https://mpdf.github.io/fonts-languages/cjk-languages.html)
  in the reader.
* **TCPDF**: TCPDF 6.x includes the `cid0jp`, `kozminproregular` and `kozgopromedium` fonts.
  They are not embedded in the PDF, so the reader needs the Asian font pack. To embed a font,
  convert a TrueType font with `TCPDF_FONTS::addTTFfont()`.
* **wkhtmltopdf**: renders with the fonts installed on the host (through fontconfig), so
  install a Japanese font on the server, for example a Noto CJK font package.

## Configuration

Use `Configure::write('CakePdf', $config);` or set the controller property `$pdfConfig`
(only when used with `PdfView`). You need to define at least `$config['engine']`. When
using `CakePdf` directly you can also pass the config array to the constructor. The value
for `engine` has the `Plugin.ClassName` format without the `Engine` suffix.

Configuration options:

* `engine`: Engine to be used (required)
* `options`: Engine options, these vary between engines
* `pageSize`: Page size, defaults to `A4`
* `orientation`: Page orientation, defaults to `portrait`
* `margin`: Array of margins with the keys `bottom`, `left`, `right` and `top`
* `title`: Title of the document
* `encoding`: Encoding, defaults to `UTF-8`
* `binary`: Path to the binary (`WkHtmlToPdf` engine only), defaults to `/usr/bin/wkhtmltopdf`
* `cache`: Cache configuration name to cache the generated PDF (`true` uses `cake_pdf`),
  disabled by default
* `download`: Set to `true` to force a download, only when using `PdfView`
* `filename`: Filename for the document when using forced download

Example:

```php
Configure::write('CakePdf', [
    'engine' => 'CakePdf.WkHtmlToPdf',
    'options' => [
        'print-media-type' => false,
        'outline' => true,
        'dpi' => 96,
    ],
    'margin' => [
        'bottom' => 15,
        'left' => 50,
        'right' => 30,
        'top' => 45,
    ],
    'orientation' => 'landscape',
    'download' => true,
]);
```

In your controller you can set additional configuration or override the global one:

```php
class InvoicesController extends AppController
{
    public function view($id = null)
    {
        $this->Invoice->id = $id;
        if (!$this->Invoice->exists()) {
            throw new NotFoundException(__('Invalid invoice'));
        }
        $this->pdfConfig = [
            'orientation' => 'portrait',
            'filename' => 'Invoice_' . $id,
        ];
        $this->set('invoice', $this->Invoice->read(null, $id));
    }
}
```

## Usage

You can use CakePdf in two ways. Read carefully which one you actually need: mixing
them does not give the expected results.

### Render as PDF in the browser with PdfView

You can create PDF view and layout files for your controller actions and have them
rendered automatically, including forced downloads.

Place the view templates in a `pdf` subdirectory, for instance
`templates/Invoices/pdf/view.ctp` (legacy layout: `app/View/Invoices/pdf/view.ctp`).
Layouts go in `templates/Layouts/pdf/default.ctp` (legacy layout:
`app/View/Layouts/pdf/default.ctp`).

Make sure your `InvoicesController` has the `RequestHandler` component in its
`$components` array, then browse to `http://localhost/invoices/view/1.pdf`.

Additionally you can map resources by adding `Router::mapResources(['Invoices']);` to your
routes file and access the same document at `http://localhost/invoices/1.pdf`.

### Create PDF for email attachments, file storage and more

You can use the `CakePdf` class to create raw PDF data with a view template. The view
template goes in `templates/Pdf/newsletter.ctp` (legacy layout: `app/View/Pdf/newsletter.ctp`)
and the layout in `templates/Layouts/pdf/default.ctp` (legacy layout:
`app/View/Layouts/pdf/default.ctp`). Layouts for both ways are in the same directory, but
the view templates use different paths. Optionally you can write the raw data to a file.

```php
App::uses('CakeEmail', 'Network/Email');
App::uses('CakePdf', 'CakePdf.Pdf');

$cakePdf = new CakePdf();
$cakePdf->template('newsletter', 'default');

// Get the PDF as a string, e.g. for an email attachment
$Email = new CakeEmail();
$Email->attachments([
    'newsletter.pdf' => ['data' => $cakePdf->output(), 'mimetype' => 'application/pdf'],
]);

// Or write it to a file directly
$cakePdf->write(APP . 'files' . DS . 'newsletter.pdf');
```

## Encryption

You can optionally encrypt the PDF with permissions. To use encryption you first need to
select a crypto engine. The following crypto engines are supported:

* Pdftk

### Enable encryption

Add the following to your bootstrap:

```php
Configure::write('CakePdf.crypto', 'CakePdf.Pdftk');
```

Options in `pdfConfig`:

* `protect`: Set to `true` to enable encryption
* `userPassword` (optional): Password to open the PDF file
* `ownerPassword` (optional): Password to unlock the locked permissions
* `permissions` (optional): The permissions

Either `userPassword` or `ownerPassword` must be set.

### Permissions

By default all permissions are denied. To allow all permissions, set `permissions` to
`true`. To allow specific permissions, set `permissions` to an array with a combination of
the following permissions:

* `print`
* `degraded_print`
* `modify`
* `assembly`
* `copy_contents`
* `screen_readers`
* `annotate`
* `fill_in`

## Static Assets

Use absolute URLs for static assets in your view templates for PDFs. If you use
`HtmlHelper::image()`, `HtmlHelper::script()` or `HtmlHelper::css()`, make sure you set
`$options['fullBase'] = true`.

Another solution is an `AppHelper` that forces `$options['fullBase'] = true` for PDF
requests:

```php
class AppHelper extends Helper
{
    public function assetUrl($path, $options = []): string
    {
        if (!empty($this->request->params['ext']) && $this->request->params['ext'] === 'pdf') {
            $options['fullBase'] = true;
        }

        return parent::assetUrl($path, $options);
    }
}
```

## Thanks

Many thanks to Kim Biesbjerg and Jelle Henkens for their contributions.
Want your name here as well? Create a pull request for improvements or other PDF engines.
