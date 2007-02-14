<?php

require('chessset.php');

$whites = $_GET['w'];
$blacks = $_GET['b'];

$board = array();

parsePieces($whites, 'w', $board);
parsePieces($blacks, 'b', $board);

$set = new ChessSet();

header("Content-type: image/png");

imagepng(placePieces($board, $set));

function parsePieces($pieces, $color, &$board)
{
    foreach (explode(",", $pieces) as $piece)
    {
        $piece = trim ($piece);
        
        if (strlen($piece) == 2)
        {
            $piece = 'P' . $piece;
        }
        
        if (strlen($piece) != 3)
            continue;
        
        $code = strtoupper(substr($piece, 0, 1));
        $col  = strtolower(substr($piece, 1, 1));
        $row  = intval(substr($piece, 2, 1));
        
        $board[$row][$col] = $color . $code;
    }
}

function placePieces($board, $set)
{
    $cols = array ('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h');
    $rows = array (8, 7, 6, 5, 4, 3, 2, 1);
    
    $boardImg = $set->getBoard();
    $size = $set->getSquareSize();
    
    $background = 'w';
    
    $offy = $set->getBoardOffsety();
    
    foreach ($rows as $row)
    {
        $offx = $set->getBoardOffsetX();
        
        foreach ($cols as $col)
        {
            if (isset($board[$row][$col]))
            {
                $color = substr($board[$row][$col], 0, 1);
                $code  = substr($board[$row][$col], 1, 1);
                
                imagecopy(
                    $boardImg,
                    $set->getPiece($code, $color, $background),
                    $offx,
                    $offy,
                    0,
                    0,
                    $size,
                    $size);
            }
            
            $background = $background == 'w' ? 'b' : 'w';
            
            $offx += $size;
        }
            
        $background = $background == 'w' ? 'b' : 'w';
        
        $offy += $size;
    }
    
    return $boardImg;
}

?>