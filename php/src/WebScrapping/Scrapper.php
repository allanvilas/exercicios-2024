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
    public function scrap(\DOMDocument $dom): array
    {
        $domNodeelem = $dom->getelementsByTagName('a');
    
        $papers = [];

        foreach($domNodeelem as $elem){
            $classAtt = $elem->getAttribute('class');
            $elemChildNodes = $elem->childNodes->length;
            // Filter only target <a> cards
            if($elemChildNodes > 0 && strpos($classAtt, 'paper-card') !== false ) {
                $id = $this->extractId($elem);
                $title = $this->extractTitle($elem);
                $type = $this->extractType($elem);
                $persons = $this->extractAuthors($elem);
        
                $localPaper = new Paper($id, $title, $type, $persons);
                array_push($papers, $localPaper);
            }
        }
        return $papers;
    }

    private function extractTitle($domelem) : string
    {
        try{
            $title = $domelem->firstChild->nodeValue;
            return $title;
        } catch(Exception $e) { 
            return 'Title not founded!';
        } 
    }

    private function extractType($domelem) : string
    {
        try{
            $type = $domelem->childNodes->item(2)->firstChild->nodeValue;
            return $type;
        } catch(Exception $e) { 
            return 'Type not founded!';
        } 
    }

    private function extractId($domelem) : string
    {
        try{
            $link = $domelem->getAttribute('href');
            $id = basename($link);
            return $id;
        } catch(Exception $e) { 
            return 'Id not founded!';
        } 
    }

    private function extractAuthors($domelem) : array
    {
        try{
            $authors = $domelem->childNodes->item(1)->childNodes;

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
