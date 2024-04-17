<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;
use Exception;

require_once 'Entity/Paper.php';
require_once 'Entity/Person.php';
/**
 * Does the scrapping of a webpage.
 */
class Scrapper {

  /**
   * Loads paper information from the HTML and returns the array with the data.
   */
  public function scrap(\DOMDocument $dom): array {
    $domNodeElem = $dom->getElementsByTagName('a');
    
    $papers = [];

    foreach($domNodeElem as $Elem){
      $classAtt = $Elem->getAttribute('class');
      $elemChildNodes = $Elem->childNodes->length;
      // Filter only target <a> cards
      if( $elemChildNodes > 0 && strpos($classAtt, 'paper-card') !== false ) {
        $id = $this->extractId($Elem);
        $title = $this->extractTitle($Elem);
        $type = $this->extractType($Elem);
        $persons = $this->ExtractAuthors($Elem);
        
        $localPaper = new Paper($id,$title,$type,$persons);
        array_push($papers,$localPaper);
      }
    }
    return $papers;
  }

  private function extractTitle($domElem) : string{
    try{
      $title = $domElem->firstChild->nodeValue;
      return $title;
    } catch(Exception $e) { 
      return 'Title not founded!';
    } 
  }

  private function extractType($domElem) : string{
    try{
      $type = $domElem->childNodes->item(2)->firstChild->nodeValue;
      return $type;
    } catch(Exception $e) { 
      return 'Type not founded!';
    } 
  }

  private function extractId($domElem) : string{
    try{
      $link = $domElem->getAttribute('href');
      $id = basename($link);
      return $id;
    } catch(Exception $e) { 
      return 'Id not founded!';
    } 
  }

  private function ExtractAuthors($domElem) : array{
    try{
      $authors = $domElem->childNodes->item(1)->childNodes;

      $persons = [];

      foreach($authors as $author){
        if($author->hasAttributes()){

          // Pushs persons to a staging array before return
          $per = new Person(
            $author->nodeValue, 
            $author->getAttribute('title')
          );

          array_push($persons,$per);            
        }
      }
      return $persons;      
    } catch(Exception $e) { 
      return [
        new Person('Person name not found','Person institution not found')
      ];
    } 
  }

}
