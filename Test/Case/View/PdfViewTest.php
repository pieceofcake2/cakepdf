<?php

App::uses('AbstractPdfEngine', 'CakePdf.Pdf/Engine');
App::uses('Controller', 'Controller');
App::uses('PdfView', 'CakePdf.View');

/**
 * Dummy engine
 */
class PdfTestEngine extends AbstractPdfEngine
{
    /**
     * @return mixed|string|null
     */
    public function output(): mixed
    {
        return $this->_Pdf->html();
    }
}

/**
 * Dummy controller
 */
class PdfTestPostsController extends Controller
{
    public $name = 'Posts';

    public $pdfConfig = ['engine' => 'PdfTest'];
}

/**
 * PdfViewTest class
 *
 * @package CakePdf.Test.Case.View
 */
class PdfViewTest extends CakeTestCase
{
    /**
     * setup callback
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $path = CakePlugin::path('CakePdf') . 'Test' . DS . 'test_app' . DS . 'View' . DS;
        App::build(['View' => $path]);

        $Controller = new PdfTestPostsController();
        $this->View = new PdfView($Controller);
        $this->View->layoutPath = 'pdf';
    }

    /**
     * testRender
     *
     * @return void
     */
    public function testConstruct(): void
    {
        $result = $this->View->response->type();
        $this->assertEquals('application/pdf', $result);

        $result = $this->View->pdfConfig;
        $this->assertEquals(['engine' => 'PdfTest'], $result);

        $result = $this->View->renderer();
        $this->assertInstanceOf('CakePdf', $result);
    }

    /**
     * testRender
     *
     * @return void
     */
    public function testRender(): void
    {
        $this->View->set('post', 'This is the post');
        $result = $this->View->render('view', 'default');

        $this->assertTrue(strpos($result, '<h2>Rendered with default layout</h2>') !== false);
        $this->assertTrue(strpos($result, 'Post data: This is the post') !== false);
    }
}
