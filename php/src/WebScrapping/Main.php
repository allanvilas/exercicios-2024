<?php

namespace Chuva\Php\WebScrapping;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

require_once 'Scrapper.php';
/**
 * Runner for the Webscrapping exercice.
 */
class Main
{
    /**
     * Main runner, instantiates a Scrapper and runs.
     */
    public static function run(): void
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');

        $data = (new Scrapper())->scrap($dom);
    
    self::WriteXLSX($data);
        self::WriteXLSX($data);

    }

  private static function WriteXLSX($data):void {

    $filePath = __DIR__ . '\\Export\\Export.xlsx';
    private static function WriteXLSX($data):void
    {

        $filePath = __DIR__ . '\\Export\\Export.xlsx';

        $writer = WriterEntityFactory::createXLSXWriter();
    
        $writer->openToFile($filePath);
    
        // Pre generate the readers.
        $titleCells = [
        WriterEntityFactory::createCell('ID'),
        WriterEntityFactory::createCell('Title'),
        WriterEntityFactory::createCell('Type'),
        WriterEntityFactory::createCell('Author 1'),
        WriterEntityFactory::createCell('Author 1 Institution'),
        WriterEntityFactory::createCell('Author 2'),
        WriterEntityFactory::createCell('Author 2 Institution'),
        WriterEntityFactory::createCell('Author 3'),
        WriterEntityFactory::createCell('Author 3 Institution'),
        WriterEntityFactory::createCell('Author 4'),
        WriterEntityFactory::createCell('Author 4 Institution'),
        WriterEntityFactory::createCell('Author 5'),
        WriterEntityFactory::createCell('Author 5 Institution'),
        WriterEntityFactory::createCell('Author 6'),
        WriterEntityFactory::createCell('Author 6 Institution'),
        WriterEntityFactory::createCell('Author 7'),
        WriterEntityFactory::createCell('Author 7 Institution'),
        WriterEntityFactory::createCell('Author 8'),
        WriterEntityFactory::createCell('Author 8 Institution'),
        WriterEntityFactory::createCell('Author 9'),
        WriterEntityFactory::createCell('Author 9 Institution')
        ];

    $Header = WriterEntityFactory::createRow($titleCells);
    $writer->addRow($Header);
        $Header = WriterEntityFactory::createRow($titleCells);
        $writer->addRow($Header);

    // Add the scrapped data to the xlsx
    foreach($data as $paper) {
      $PaperRow = [
        WriterEntityFactory::createCell($paper->id),  
        WriterEntityFactory::createCell($paper->title),  
        WriterEntityFactory::createCell($paper->type),  
      ];
      foreach($paper->authors as $key => $person) {
        array_push($PaperRow, WriterEntityFactory::createCell(str_replace(';','',$person->name)));
        array_push($PaperRow, WriterEntityFactory::createCell($person->institution));
      }
        // Add the scrapped data to the xlsx
        foreach($data as $paper) {
            $PaperRow = [
            WriterEntityFactory::createCell($paper->id),  
            WriterEntityFactory::createCell($paper->title),  
            WriterEntityFactory::createCell($paper->type),  
            ];
            foreach($paper->authors as $key => $person) {
                array_push($PaperRow, WriterEntityFactory::createCell(str_replace(';', '', $person->name)));
                array_push($PaperRow, WriterEntityFactory::createCell($person->institution));
            }

      $paperData = WriterEntityFactory::createRow($PaperRow);
      $writer->addRow($paperData);
    }
            $paperData = WriterEntityFactory::createRow($PaperRow);
            $writer->addRow($paperData);
        }
    
        $writer->close();
    }

}

