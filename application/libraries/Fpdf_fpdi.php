<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/fpdf/fpdf.php');
require_once(APPPATH . 'libraries/fpdi/src/autoload.php');

use setasign\Fpdi\Fpdi;

class Fpdf_fpdi extends Fpdi {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Merge multiple PDF files
     * @param array $files List of file paths
     * @param string $outputFile Output file name
     * @param string $dest D=Download, F=Save to file, I=Inline open
     */
    public function merge($files = [], $outputFile = 'merged.pdf', $dest = 'D') {
        foreach ($files as $file) {
            $pageCount = $this->setSourceFile($file);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $this->importPage($pageNo);
                $size = $this->getTemplateSize($templateId);
                $this->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $this->useTemplate($templateId);
            }
        }
        $this->Output($outputFile, $dest);
    }
}
