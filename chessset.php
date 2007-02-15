<?php

class ChessSet
{
    var $boardImg;
    var $pieces = array();
    var $folder;
    var $info;
    
    function ChessSet($setFolder = 'default')
    {
        $this->folder = $setFolder . '/';
        
        $this->info = parse_ini_file($this->folder . "set.info");
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
        return intval($this->info['square_size']);
    }
    
    function getMarginLeft()
    {
        return intval($this->info['margin_left']);
    }
    
    function getMarginRigh()
    {
        return intval($this->info['margin_right']);
    }
    
    function getMarginTop()
    {
        return intval($this->info['margin_top']);
    }
    
    function getMarginBottom()
    {
        return intval($this->info['margin_bottom']);
    }
    
    function getBoardWidth()
    {
        return $this->getMarginLeft() + $this->getSquareSize() * 8 + $this->getMarginRigh();
    }
    
    function getBoardHeight()
    {
        return $this->getMarginTop() + $this->getSquareSize() * 8 + $this->getMarginBottom();
    }
}

?>