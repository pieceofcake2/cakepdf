# CakePdf ドキュメント

CakePdf は、PDF エンジンを使って HTML を PDF に変換します。`PdfView` でコントローラーのアクションを
PDF として出力したり、メールの添付ファイルやファイルの保存などのための PDF ファイルを作成したりできます。

対応しているエンジン:

* Dompdf
* mPDF
* TCPDF
* wkhtmltopdf (`wkhtmltopdf` バイナリが必要です)

各エンジンへのリンク、ライセンス、注意点は [エンジンとライセンス](#engines-and-licenses) をご覧ください。

- [インストール](#installation)
- [エンジンとライセンス](#engines-and-licenses)
- [設定](#configuration)
- [使い方](#usage)
- [暗号化](#encryption)
- [静的アセット](#static-assets)
- [謝辞](#thanks)

<a id="installation"></a>

## インストール

[Composer](https://getcomposer.org/) でプラグインをインストールします。

```bash
composer require pieceofcake2/cakepdf
```

このプラグインのタイプは `cakephp-plugin` なので、`composer/installers` によってプラグインディレクトリに
(`CakePdf` として) インストールされます。正しい場所にインストールされるように、アプリケーションの
`composer.json` で `installer-paths` を設定してください。

| レイアウト | `installer-paths` |
| --- | --- |
| モダン (`config/`、`src/`、`templates/`、`plugins/`) | `"plugins/{$name}/": ["type:cakephp-plugin"]` |
| レガシー (`app/Config/`、`app/Plugin/`) | `"app/Plugin/{$name}/": ["type:cakephp-plugin"]` |

使うエンジンのライブラリをインストールします。

| エンジン | 必要なもの |
| --- | --- |
| `CakePdf.DomPdf` | `composer require dompdf/dompdf` |
| `CakePdf.Mpdf` | `composer require mpdf/mpdf` |
| `CakePdf.Tcpdf` | `composer require tecnickcom/tcpdf` |
| `CakePdf.WkHtmlToPdf` | [wkhtmltopdf](https://wkhtmltopdf.org/) のバイナリ |

暗号化には、さらに [pdftk](https://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/) のバイナリが必要です。

<a id="enable-the-plugin"></a>

### プラグインの有効化

`config/bootstrap.php` (レガシーレイアウトでは `app/Config/bootstrap.php`) で、プラグインを
ブートストラップとルートと一緒に読み込みます。

```php
CakePlugin::load('CakePdf', ['bootstrap' => true, 'routes' => true]);
```

このルートによって `.pdf` 拡張子が有効になります。

<a id="engines-and-licenses"></a>

## エンジンとライセンス

CakePdf 自体は MIT ライセンスで公開されています。各エンジンは別のプロジェクトで、それぞれのライセンスは
次の表のとおりです。インストールするエンジンのライセンスを確認してください。

| エンジン | ライブラリ | Composer パッケージ | ライセンス | 種類 | 注意点 |
| --- | --- | --- | --- | --- | --- |
| `CakePdf.DomPdf` | [Dompdf](https://dompdf.github.io/) ([GitHub](https://github.com/dompdf/dompdf)) | [`dompdf/dompdf`](https://packagist.org/packages/dompdf/dompdf) `^3.1` | [LGPL-2.1](https://github.com/dompdf/dompdf/blob/master/LICENSE.LGPL) | PHP ライブラリ | PHP `^7.1 \|\| ^8.0`。主に CSS 2.1 と一部の CSS3 プロパティに対応します。flexbox や grid には対応せず、表の 1 行は 1 ページに収まる必要があります。DejaVu フォントを同梱しています。 |
| `CakePdf.Mpdf` | [mPDF](https://mpdf.github.io/) ([GitHub](https://github.com/mpdf/mpdf)) | [`mpdf/mpdf`](https://packagist.org/packages/mpdf/mpdf) `^8.0` | [GPL-2.0-only](https://github.com/mpdf/mpdf/blob/development/LICENSE.txt) | PHP ライブラリ | PHP 5.6 から 8.5 (8.5 は mPDF 8.2.6 から)。Unicode と CJK のフォントを同梱しています。 |
| `CakePdf.Tcpdf` | [TCPDF](https://tcpdf.org/) ([GitHub](https://github.com/tecnickcom/TCPDF)) | [`tecnickcom/tcpdf`](https://packagist.org/packages/tecnickcom/tcpdf) `^6.10` | [LGPL-3.0-or-later](https://github.com/tecnickcom/TCPDF/blob/main/LICENSE.TXT) | PHP ライブラリ | TCPDF 6.x には PHP 7.1 以上が必要です。アップストリームは TCPDF を非推奨でメンテナンスのみとしており、開発は [tc-lib-pdf](https://github.com/tecnickcom/tc-lib-pdf) に移っています。TCPDF 7.x (PHP 8.2 以上) は tc-lib-pdf の上の互換レイヤーで、CakePdf ではテストしていません。`writeHTML()` が対応する HTML タグは限られており、整形式の HTML が必要です。 |
| `CakePdf.WkHtmlToPdf` | [wkhtmltopdf](https://wkhtmltopdf.org/) ([GitHub](https://github.com/wkhtmltopdf/wkhtmltopdf)) | なし (システムのバイナリ) | [LGPL-3.0-or-later](https://github.com/wkhtmltopdf/wkhtmltopdf/blob/master/LICENSE) | 外部バイナリ | **メンテナンスされていません**。GitHub リポジトリはアーカイブされており、最後のリリースは 0.12.6 (2020 年 6 月) です。古い Qt WebKit でレンダリングします。[プロジェクトの状況](https://wkhtmltopdf.org/status.html) をご覧ください。アップストリームは、信頼できない HTML に使わないよう警告しています。ホストにインストールされたフォントを使います。 |

バージョンは、CakePdf が開発用にインストールするもの (`composer.json` の `require-dev`) です。
CakePdf は、インストールするエンジンのバージョンを制限しません。

[暗号化](#encryption) に使う、省略可能な [pdftk](https://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/)
のバイナリも外部プログラムです。PDFtk Server は [GPL バージョン 2](https://www.pdflabs.com/docs/pdftk-license/)
または商用の再頒布ライセンスで提供されており、移植版の [pdftk-java](https://gitlab.com/pdftk-java/pdftk) は
GPL バージョン 2 以降でライセンスされています。

<a id="japanese-text-cjk"></a>

### 日本語のテキスト (CJK)

標準の PDF フォントには日本語の文字が含まれていないので、どのエンジンでも CJK のグリフを持つフォントが
必要です。

* **Dompdf**: 同梱の DejaVu フォントは日本語に対応していません。日本語の TrueType フォント
  (たとえば Noto Sans JP) を CSS の `@font-face` ルールで指定し、`font-family` で使ってください。
  [About Fonts and Character Encoding](https://github.com/dompdf/dompdf/wiki/About-Fonts-and-Character-Encoding)
  をご覧ください。
* **mPDF**: CJK に対応した `Sun-ExtA` と `Sun-ExtB` フォントを同梱しています。CSS で
  `font-family: sun-exta;` として使ってください。埋め込まれないフォント (Adobe の CJK フォントなど) は、
  閲覧ソフトに [アジア言語フォントパック](https://mpdf.github.io/fonts-languages/cjk-languages.html)
  が必要です。
* **TCPDF**: TCPDF 6.x には `cid0jp`、`kozminproregular`、`kozgopromedium` フォントが含まれています。
  これらは PDF に埋め込まれないので、閲覧ソフトにアジア言語フォントパックが必要です。フォントを埋め込むには、
  `TCPDF_FONTS::addTTFfont()` で TrueType フォントを変換してください。
* **wkhtmltopdf**: ホストにインストールされたフォントで (fontconfig を通して) レンダリングするので、
  サーバーに日本語フォント、たとえば Noto CJK のフォントパッケージをインストールしてください。

<a id="configuration"></a>

## 設定

`Configure::write('CakePdf', $config);` を使うか、コントローラーの `$pdfConfig` プロパティを設定します
(`PdfView` と一緒に使う場合のみ)。少なくとも `$config['engine']` を定義する必要があります。`CakePdf` を
直接使う場合は、設定の配列をコンストラクターに渡すこともできます。`engine` の値は、`Engine` サフィックスを
除いた `Plugin.ClassName` の形式です。

設定のオプション:

* `engine`: 使うエンジン (必須)
* `options`: エンジンのオプション。エンジンによって異なります
* `pageSize`: ページサイズ。デフォルトは `A4`
* `orientation`: ページの向き。デフォルトは `portrait`
* `margin`: `bottom`、`left`、`right`、`top` をキーとする余白の配列
* `title`: ドキュメントのタイトル
* `encoding`: エンコーディング。デフォルトは `UTF-8`
* `binary`: バイナリのパス (`WkHtmlToPdf` エンジンのみ)。デフォルトは `/usr/bin/wkhtmltopdf`
* `cache`: 生成した PDF をキャッシュするキャッシュ設定の名前 (`true` の場合は `cake_pdf` を使います)。
  デフォルトでは無効です
* `download`: `true` にするとダウンロードを強制します。`PdfView` を使う場合のみ
* `filename`: ダウンロードを強制するときのドキュメントのファイル名

例:

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

コントローラーでは、設定を追加したり、グローバルな設定を上書きしたりできます。

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

<a id="usage"></a>

## 使い方

CakePdf には 2 つの使い方があります。実際に必要なのはどちらか、よく読んでください。両方を混ぜると、
期待どおりの結果になりません。

<a id="render-as-pdf-in-the-browser-with-pdfview"></a>

### PdfView でブラウザーに PDF として出力する

コントローラーのアクション用に PDF のビューとレイアウトのファイルを作り、強制ダウンロードも含めて
自動的に出力させることができます。

ビューテンプレートは `pdf` サブディレクトリに置きます。たとえば `templates/Invoices/pdf/view.ctp`
(レガシーレイアウトでは `app/View/Invoices/pdf/view.ctp`) です。レイアウトは
`templates/Layouts/pdf/default.ctp` (レガシーレイアウトでは `app/View/Layouts/pdf/default.ctp`)
に置きます。

`InvoicesController` の `$components` 配列に `RequestHandler` コンポーネントがあることを確認し、
`http://localhost/invoices/view/1.pdf` を開きます。

さらに、ルートファイルに `Router::mapResources(['Invoices']);` を追加してリソースをマッピングすると、
同じドキュメントに `http://localhost/invoices/1.pdf` でアクセスできます。

<a id="create-pdf-for-email-attachments-file-storage-and-more"></a>

### メールの添付ファイルやファイルの保存などのための PDF を作成する

`CakePdf` クラスを使うと、ビューテンプレートから PDF の生データを作成できます。ビューテンプレートは
`templates/Pdf/newsletter.ctp` (レガシーレイアウトでは `app/View/Pdf/newsletter.ctp`) に、レイアウトは
`templates/Layouts/pdf/default.ctp` (レガシーレイアウトでは `app/View/Layouts/pdf/default.ctp`)
に置きます。どちらの使い方でもレイアウトは同じディレクトリにありますが、ビューテンプレートのパスは
異なります。必要に応じて、生データをファイルに書き出すこともできます。

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

<a id="encryption"></a>

## 暗号化

必要に応じて、PDF を権限付きで暗号化できます。暗号化を使うには、まず暗号化エンジンを選ぶ必要が
あります。対応している暗号化エンジンは次のとおりです。

* Pdftk

<a id="enable-encryption"></a>

### 暗号化の有効化

ブートストラップに次のように追加します。

```php
Configure::write('CakePdf.crypto', 'CakePdf.Pdftk');
```

`pdfConfig` のオプション:

* `protect`: `true` にすると暗号化が有効になります
* `userPassword` (省略可): PDF ファイルを開くためのパスワード
* `ownerPassword` (省略可): ロックされた権限を解除するためのパスワード
* `permissions` (省略可): 権限

`userPassword` と `ownerPassword` のどちらかを設定する必要があります。

<a id="permissions"></a>

### 権限

デフォルトでは、すべての権限が拒否されます。すべての権限を許可するには、`permissions` を `true` に
します。特定の権限を許可するには、`permissions` に次の権限を組み合わせた配列を設定します。

* `print`
* `degraded_print`
* `modify`
* `assembly`
* `copy_contents`
* `screen_readers`
* `annotate`
* `fill_in`

<a id="static-assets"></a>

## 静的アセット

PDF 用のビューテンプレートでは、静的アセットに絶対 URL を使ってください。`HtmlHelper::image()`、
`HtmlHelper::script()`、`HtmlHelper::css()` を使う場合は、必ず `$options['fullBase'] = true` を
設定してください。

別の方法として、PDF のリクエストでは `$options['fullBase'] = true` を強制する `AppHelper` を使えます。

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

<a id="thanks"></a>

## 謝辞

Kim Biesbjerg と Jelle Henkens の貢献に深く感謝します。
ここに名前を載せたい方は、改善やほかの PDF エンジンのためのプルリクエストを作成してください。

<a id="origin"></a>

## 由来

このパッケージは
[FriendsOfCake/CakePdf](https://github.com/FriendsOfCake/CakePdf)
(Packagist では `friendsofcake/cakepdf`、アップストリームの最終バージョンは 1.0.3)
のメンテナンスされたフォークで、元は Ceeram によって作られました。
[pieceofcake2](https://github.com/pieceofcake2) が、モダンな PHP 上の CakePHP 2 向けにメンテナンスしています。
オリジナルからの変更点は
[フォーク以降のコミット履歴](https://github.com/pieceofcake2/cakepdf/compare/82750dd...1.x)
にあります。
