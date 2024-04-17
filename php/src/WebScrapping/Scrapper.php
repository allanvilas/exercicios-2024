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
class Scrapper
{

  /**
   * Loads paper information from the HTML and returns the array with the data.
   */
  public function scrap(\DOMDocument $dom): array {
    $DomNodeElem = $dom->getElementsByTagName('a');
    
        $papers = [];

    foreach($DomNodeElem as $Elem){
      $classAtt = $Elem->getAttribute('class');
      $ElemChildNodes = $Elem->childNodes->length;
      // Filter only target <a> cards
      if( $ElemChildNodes > 0 && strpos($classAtt, 'paper-card') !== false ) {
        $id = $this->ExtractID($Elem);
        $title = $this->ExtractTitle($Elem);
        $type = $this->ExtractType($Elem);
        $persons = $this->ExtractAuthors($Elem);
        
                $localPaper = new Paper($id, $title, $type, $persons);
                array_push($papers, $localPaper);
            }
        }
        return $papers;
    }

  private function ExtractTitle($DOMElem) : string{
    try{
      $title = $DOMElem->firstChild->nodeValue;
      return $title;
    } catch(Exception $e) { 
      return 'Title not founded!';
    } 
  }

  private function ExtractType($DOMElem) : string{
    try{
      $type = $DOMElem->childNodes->item(2)->firstChild->nodeValue;
      return $type;
    } catch(Exception $e) { 
      return 'Type not founded!';
    } 
  }

  private function ExtractID($DOMElem) : string{
    try{
      $link = $DOMElem->getAttribute('href');
      $id = basename($link);
      return $id;
    } catch(Exception $e) { 
      return 'Id not founded!';
    } 
  }

  private function ExtractAuthors($DOMElem) : array{
    try{
      $authors = $DOMElem->childNodes->item(1)->childNodes;

            $persons = [];

            foreach($authors as $author){
                if($author->hasAttributes()) {

                    // Pushs persons to a staging array before return
                    $per = new Person(
                        $author->nodeValue, 
                        $author->getAttribute('title')
                    );

                    array_push($persons, $per);            
                }
            }
            return $persons;      
        } catch(Exception $e) { 
            return [
            new Person('Person name not found', 'Person institution not found')
            ];
        } 
    }

}
