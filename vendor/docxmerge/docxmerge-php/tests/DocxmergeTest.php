<?php

use Docxmerge\Docxmerge;

class DocxmergeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function testRenderTemplate()
    {
        self::assertTrue(true);
        $docxmerge = $this->getDocxmerge();
        $fp = fopen("../tmp/helloworld-transform.pdf", "w");
        $data = array(
            "logo" => "https://docxmerge.com/assets/android-chrome-512x512.png",
            "name" => "James Bond"
        );
        try {
            $docxmerge->renderTemplate($fp, "hello_world", $data, "PDF");
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testRenderUrl()
    {
        self::assertTrue(true);
        $url = "https://api.docxmerge.com/api/v1/File/GetContenido?id=cdb9842d-5e38-4149-a06b-e1079a208fc3&download=true";
        $docxmerge = $this->getDocxmerge();
        $fp = fopen("../tmp/helloworld-transform.pdf", "w");
        $data = array(
            "logo" => "https://docxmerge.com/assets/android-chrome-512x512.png",
            "name" => "James Bond"
        );
        try {
            $docxmerge->renderUrl($fp, $url, $data, "PDF");
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testRenderFile()
    {
        self::assertTrue(true);
        $docxmerge = $this->getDocxmerge();
        $fp = fopen("../tmp/helloworld-transform-doc.pdf", "w");
        try {
            $data = array(
                "logo" => "https://docxmerge.com/assets/android-chrome-512x512.png",
                "name" => "James Bond"
            );
            $docxmerge->renderFile($fp, "../fixtures/helloworld.docx", $data, "PDF");
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }
//
//    public function testMergeTemplate()
//    {
//        self::assertTrue(true);
//        $docxmerge = $this->getDocxmerge();
//        $fp = fopen("../tmp/helloworld-merge.docx", "w");
//        $data = array(
//            'hello_world' => 'Hola mundo',
//        );
//        try {
//            $docxmerge->mergeTemplate($fp, "helloworld", $data);
//        } catch (Exception $e) {
//            $this->fail($e->getMessage());
//        }
//    }
//
//    public function testMergeDocument()
//    {
//        self::assertTrue(true);
//        $docxmerge = $this->getDocxmerge();
//        $fp = fopen("../tmp/helloworld-merge-doc.docx", "w");
//        $data = array(
//            'hello_world' => 'Hola mundo',
//        );
//        try {
//            $docxmerge->mergeDocument($fp, "../fixtures/helloworld.docx", $data);
//        } catch (Exception $e) {
//            $this->fail($e->getMessage());
//        }
//    }
//
//    public function testMergeAndTransformTemplate()
//    {
//        self::assertTrue(true);
//        $docxmerge = $this->getDocxmerge();
//        $fp = fopen("../tmp/helloworld-merge.docx", "w");
//        $data = array(
//            'hello_world' => 'Hola mundo',
//        );
//        try {
//            $docxmerge->mergeAndTransformTemplate($fp, "helloworld", $data);
//        } catch (Exception $e) {
//            $this->fail($e->getMessage());
//        }
//    }
//
//    public function testMergeAndTransformDocument()
//    {
//        self::assertTrue(true);
//        $docxmerge = $this->getDocxmerge();
//        $fp = fopen("../tmp/helloworld-merge-doc.pdf", "w");
//        $data = array(
//            'hello_world' => 'Hola mundo',
//        );
//        try {
//            $docxmerge->mergeAndTransformDocument($fp, "../fixtures/helloworld.docx", $data);
//        } catch (Exception $e) {
//            $this->fail($e->getMessage());
//        }
//    }

    private function getDocxmerge()
    {
        $apiKey = '26JZ5iPpD4U3b9z7lqkXeB2OGsbdF7';
        $baseUrl = "http://localhost:5101";
        $tenant = "default";
        return new Docxmerge($apiKey, $tenant, $baseUrl);
    }
}
