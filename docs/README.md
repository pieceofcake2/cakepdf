# CakePdf Documentation

CakePdf converts HTML to PDF with a PDF engine. It renders controller actions as PDF
with `PdfView` and creates PDF files for email attachments, file storage and more.

Supported engines:

* Dompdf
* mPDF
* TCPDF
* wkhtmltopdf (requires the `wkhtmltopdf` binary) **recommended**

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Encryption](#encryption)
- [Static Assets](#static-assets)
- [Thanks](#thanks)

## Installation

Install the plugin with [Composer](https://getcomposer.org/):

```
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
