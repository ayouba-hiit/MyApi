<?php

namespace App\Service;

class ChainService
{
    /**
     * @param string $chain
     *
     * @return array
     */
    public function getGreatestOccurrence(string $chain): array
    {
        $splitedArray = str_split($chain);

        $separatedCharsArray = [];
        foreach ($splitedArray as $key => $char){
            if($key != 0 && $char !== $splitedArray[$key-1]) {
                $separatedCharsArray[] = ';';
            }
            $separatedCharsArray[] = $char;
        }

        $separatedString = implode($separatedCharsArray);

        $charsArray = explode(';', $separatedString);

        $response = ['length' => 0, 'char' => null];
        
        foreach ($charsArray as $key => $chain){
            if($response['length'] < strlen($chain)) {
                $response['length'] = strlen($chain);
                $response['char'] = substr($chain,0,1);
            }
        }

        return $response;
    }

}