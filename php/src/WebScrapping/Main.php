<?php

namespace Chuva\Php\WebScrapping;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

require_once 'Scrapper.php';
/**
 * Runner for the Webscrapping exercice.
 */
class Main {
  /**
   * Main runner, instantiates a Scrapper and runs.
   */
  public static function run(): void {
    $dom = new \DOMDocument('1.0', 'utf-8');
    $dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');
    $data = (new Scrapper())->scrap($dom);
    self::writerXlsx($data);
  }

  private static function writerXlsx($data):void {
    
    // Export scrapped data as xlsx.

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
      WriterEntityFactory::createCell('Author 9 Institution'),
    ];

    $header = WriterEntityFactory::createRow($titleCells);
    $writer->addRow($header);

    // Add the scrapped data to the xlsx.
    foreach ($data as $paper) {

      $paperRow = [
        WriterEntityFactory::createCell($paper->id), 
        WriterEntityFactory::createCell($paper->title), 
        WriterEntityFactory::createCell($paper->type),
      ];
      foreach ($paper->authors as $key => $person) {

        array_push($paperRow, WriterEntityFactory::createCell(str_replace(';', '', $person->name)));
        array_push($paperRow, WriterEntityFactory::createCell($person->institution));
      }

      $paperData = WriterEntityFactory::createRow($paperRow);
      $writer->addRow($paperData);
    }

    $writer->close();

  }

}
