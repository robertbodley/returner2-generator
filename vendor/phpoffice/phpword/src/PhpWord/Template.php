<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2016 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord;

/**
 * @deprecated 0.12.0 Use `\PhpOffice\PhpWord\TemplateProcessor` instead.
 *
 * @codeCoverageIgnore
 */
class Template extends \PhpOffice\PhpWord\TemplateProcessor
{
    /**
     * Content of document rels (in XML format) of the temporary document.
     *
     * @var string
     */
    private $temporaryDocumentRels;

    public function __construct($documentTemplate)
    {
        parent::__construct($documentTemplate);
        $this->temporaryDocumentRels = $this->zipClass->getFromName('word/_rels/document.xml.rels');
    }

    /**
     * Set a new image
     *
     * @param string $search
     * @param string $replace
     */
    public function setImageValue($search, $replace){
        // Sanity check
        if (!file_exists($replace)) {
            throw new \Exception("Image not found at:'$replace'");
        }

        // Delete current image
        $this->zipClass->deleteName('word/media/' . $search);

        // Add a new one
        $this->zipClass->addFile($replace, 'word/media/' . $search);
    }

    /**
     * Search for the labeled image's rId
     *
     * @param string $search
     */
    public function seachImagerId($search){
        if (substr($search, 0, 2) !== '${' && substr($search, -1) !== '}') {
            $search = '${' . $search . '}';
        }
        $tagPos = strpos($this->temporaryDocumentRels, $search);
        $rIdStart = strpos($this->temporaryDocumentRels, 'r:embed="',$tagPos)+9;
        $rId=strstr(substr($this->temporaryDocumentRels, $rIdStart),'"', true);
        return $rId;
    }

    /**
     * Get img filename with it's rId
     *
     * @param string $rId
     */
    public function getImgFileName($rId){
        $tagPos = strpos($this->temporaryDocumentRels, $rId);
        $fileNameStart = strpos($this->temporaryDocumentRels, 'Target="media/',$tagPos)+14;
        $fileName=strstr(substr($this->temporaryDocumentRels, $fileNameStart),'"', true);
        return $fileName;
    }

    public function setImageValueAlt($searchAlt, $replace)
    {
        $this->setImageValue($this->getImgFileName($this->seachImagerId($searchAlt)),$replace);
    }
}
