<?php

class ChessSet
{
    var $boardImg;
    var $pieces = array();
    var $folder;
    
    function ChessSet($setFolder = 'default')
    {
        $this->folder = $setFolder . '/';
    }
    
    function getBoard()
    {
        if (!isset($boardImg))
        {
            $boardImg = imagecreatefrompng($this->folder . 'board.png');
        }
        
        return $boardImg;
    }
    
    function getPiece($code, $color, $background)
    {
        if (!isset($pieces[$code][$color][$background]))
        {
            $filename = $this->folder . strtolower($background . $color) . strtoupper($code) . '.png';
            
            $pieces[$code][$color][$background] = imagecreatefrompng($filename);
        }
        
        return $pieces[$code][$color][$background];
    }
    
    function getSquareSize()
    {
        return 32;
    }
    
    function getBoardOffsetX()
    {
        return 6;
    }
    
    function getBoardOffsetY()
    {
        return 6;
    }
}

?>