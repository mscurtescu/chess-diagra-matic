<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Chess-Diagra-Matic</title>
    <?php
    require('chessset.php');
    
    $setName = 'cheq';
    $set = new ChessSet($setName);
    $setFolder = 'sets/' . $setName;
    ?>
    <style type="text/css">
        #white-pieces
        {
            margin: <?=$set->getMarginLeft()?>px 0 0 0;
            padding: 0;
            width: <?=$set->getBoardWidth()?>px;
            height: <?=$set->getSquareSize()?>px;
            position: relative;
        }
        
        #black-pieces
        {
            margin: 0 0 <?=$set->getMarginLeft()?>px 0;
            padding: 0;
            width: <?=$set->getBoardWidth()?>px;
            height: <?=$set->getSquareSize()?>px;
            position: relative;
        }
        
        #white-pieces img, #black-pieces img
        {
            margin: 0;
            width: <?=$set->getSquareSize()?>px;
            height: <?=$set->getSquareSize()?>px;
        }
        
<?php
    $left = $set->getMarginLeft();
    
    foreach (array('K', 'Q', 'B', 'N', 'R', 'P') as $pieceCode)
    {
        $left += $set->getSquareSize();
?>
        #w<?=$pieceCode?>, #b<?=$pieceCode?>
        
        {
            position: absolute;
            top: 0;
            left: <?=$left?>px;
        }
        
<?php } ?>

        #O, #X
        {
            position: absolute;
            top: 0;
            left: <?=$set->getMarginLeft() + $set->getSquareSize() * 7?>px;
        }
        
        #board
        {
            position: relative;
            padding: 0;
            margin: 0;
            width: <?=$set->getBoardWidth()?>px;
            height: <?=$set->getBoardWidth()?>px;
            background-image: url(<?=$setFolder?>/board.png);
        }
        
<?php
    $left = $set->getMarginLeft();
    
    foreach (array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h') as $col)
    {
?>
        .c<?=$col?>
        
        {
            position: absolute;
            left: <?=$left?>px;
            width: <?=$set->getSquareSize()?>px;
            height: <?=$set->getSquareSize()?>px;
        }
        
<?php
        $left += $set->getSquareSize();
    }
?>
        
<?php
    $top = $set->getMarginTop();
    
    for ($row = 8; $row >= 1; $row--)
    {
?>
        .r<?=$row?>
        
        {
            top: <?=$top?>px;
        }
        
<?php
        $top += $set->getSquareSize();
    }
?>
        
        .hover-cell
        {
            border: 1px solid red;
        }
        
        #position-editor
        {
            padding: 1em 0 0 3em;
            display: none;
        }
        
    </style>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/iutil.js"></script>
    <script type="text/javascript" src="js/idrag.js"></script>
    <script type="text/javascript" src="js/idrop.js"></script>
    <script type="text/javascript">
    var movingNow;
    
    function movePieceToCell(piece, cell)
    {
        var imgSelector = "#" + cell.id + " img";
        
        $(imgSelector).remove();
        
        var imgTag = "<img class='draggable' src='" + piece.src + "' alt='" + piece.alt + "' title='" + piece.title + "' />";
        
        $(cell).append(imgTag);
        
        if (piece.id == "")
        {
            $(piece).remove();
        }
        
        $(imgSelector).Draggable(
            {
                revert:  true,
                onStart: pieceMoveStarted,
                onStop:  pieceMoveStopped
            }
        );
    }
    
    function pieceDropped(drag)
    {
        movePieceToCell(drag, this);
        
        movingNow = null;
    }
    
    function pieceMoveStarted()
    {
        movingNow = this;
    }
    
    function pieceMoveStopped()
    {
        if (this == movingNow)
        {
            $(this).remove();
        }
    }
    
    $(document).ready(
	function()
	{
            var colorCodes = new Array('b', 'w');
            var pieceCodes = new Array('K', 'Q', 'B', 'N', 'R', 'P', 'O', 'X');
            
            for (i = 0; i < colorCodes.length; i++)
            {
                var colorCode = colorCodes[i];
                
                for (j = 0; j < pieceCodes.length; j++)
                {
                    var pieceCode = pieceCodes[j];
                    var pieceId;
                    
                    if (pieceCode == 'O' || pieceCode == 'X')
                        pieceId = '#' + pieceCode;
                    else
                        pieceId = '#' + colorCode + pieceCode;
                    
                    $(pieceId).Draggable(
                        {
                            ghosting: true,
                            revert: true
                        }
                    );
                }
            }
            
            for (col = 'a'; col <= 'h'; col = String.fromCharCode(col.charCodeAt(0) + 1))
            {
                for (row = 1; row <= 8; row++)
                {
                    var cellId = '#' + col + row;
                    
                    $(cellId).Droppable(
                        {
                            accept: 'draggable',
                            hoverclass: 'hover-cell',
                            onDrop: pieceDropped
                        }
                    );
                }
            }
        }
    );
    
    function clearBoard()
    {
        for (row = 8; row >= 1; row--)
        {
            for (col = 'a'; col <= 'h'; col = String.fromCharCode(col.charCodeAt(0) + 1))
            {
                var cellId = '#' + col + row;
                
                $(cellId + ' img').remove();
            }
        }
    }
    
    function resetBoard()
    {
        doEnterPositions(
            "Ra1,Nb1,Bc1,Qd1,Ke1,Bf1,Ng1,Rh1,Pa2,Pb2,Pc2,Pd2,Pe2,Pf2,Pg2,Ph2",
            "Ra8,Nb8,Bc8,Qd8,Ke8,Bf8,Ng8,Rh8,Pa7,Pb7,Pc7,Pd7,Pe7,Pf7,Pg7,Ph7"
        );
    }
    
    function toggleEnterPositions()
    {
        $('#position-editor').slideToggle('fast');
    }
    
    function enterPositions()
    {
        doEnterPositions(
            $('#position-editor > input[@name=w]').val(),
            $('#position-editor > input[@name=b]').val()
        );
        
        $('#position-editor > input[@name=w]').val('');
        $('#position-editor > input[@name=b]').val('');
        
        toggleEnterPositions();
    }
    
    function doEnterPositions(white, black)
    {
        clearBoard();
        
        doEnterPositionsColor(white.split(','), 'w');
        doEnterPositionsColor(black.split(','), 'b');
    }
    
    function doEnterPositionsColor(positions, color)
    {
        for (i = 0; i < positions.length; i++)
        {
            var pieceId;
            var cellId;
            
            if (positions[i].length == 2)
            {
                pieceId = 'P';
                cellId = positions[i];
            }
            else if (positions[i].length == 3)
            {
                pieceId = positions[i].charAt(0);
                cellId = positions[i].substr(1);
            }
            else
                continue;
            
            if (pieceId != 'X' && pieceId != 'O')
                pieceId = color + pieceId;
            
            movePieceToCell($('#'+pieceId)[0], $('#'+cellId)[0]);
        }
    }
    
    function readPositions()
    {
        var whites = '';
        var blacks = '';
        
        for (row = 8; row >= 1; row--)
        {
            for (col = 'a'; col <= 'h'; col = String.fromCharCode(col.charCodeAt(0) + 1))
            {
                var cellId = '#' + col + row;
                
                var imgs = $(cellId + ' > img')
                if (imgs.length > 0)
                {
                    imgSrc = imgs[0].src;
                    piece = imgSrc.charAt(imgSrc.length - 5);
                    color = imgSrc.charAt(imgSrc.length - 6);
                    
                    if (color == 'w')
                    {
                        whites = whites + ',' + piece + col + row
                    }
                    else
                    {
                        blacks = blacks + ',' + piece + col + row
                    }
                }
            }
        }
        
        if (whites.length > 0)
            whites = whites.substr(1);
        
        if (blacks.length > 0)
            blacks = blacks.substr(1);
        
        $('#get-image-form > input[@name=w]').val(whites);
        $('#get-image-form > input[@name=b]').val(blacks);
        
        return true;
    }
    </script>
</head>

<body>
    
    <div id="drag-drop-area">
        
        <div id="black-pieces">
            <img id="bK" class="draggable" src="<?=$setFolder?>/bK.png" alt="Black King" title="Black King" />
            <img id="bQ" class="draggable" src="<?=$setFolder?>/bQ.png" alt="Black Queen" title="Black Queen" />
            <img id="bB" class="draggable" src="<?=$setFolder?>/bB.png" alt="Black Bishop" title="Black Bishop" />
            <img id="bN" class="draggable" src="<?=$setFolder?>/bN.png" alt="Black Knight" title="Black Knight" />
            <img id="bR" class="draggable" src="<?=$setFolder?>/bR.png" alt="Black Rook" title="Black Rook" />
            <img id="bP" class="draggable" src="<?=$setFolder?>/bP.png" alt="Black Pawn" title="Black Pawn" />
            <img id="O" class="draggable" src="<?=$setFolder?>/O.png" alt="Marker - disc" title="Marker - disc" />
        </div>
        
        <div id="board">
            <div id="a1" class="dropzone ca r1"></div>
            <div id="a2" class="dropzone ca r2"></div>
            <div id="a3" class="dropzone ca r3"></div>
            <div id="a4" class="dropzone ca r4"></div>
            <div id="a5" class="dropzone ca r5"></div>
            <div id="a6" class="dropzone ca r6"></div>
            <div id="a7" class="dropzone ca r7"></div>
            <div id="a8" class="dropzone ca r8"></div>
            
            <div id="b1" class="dropzone cb r1"></div>
            <div id="b2" class="dropzone cb r2"></div>
            <div id="b3" class="dropzone cb r3"></div>
            <div id="b4" class="dropzone cb r4"></div>
            <div id="b5" class="dropzone cb r5"></div>
            <div id="b6" class="dropzone cb r6"></div>
            <div id="b7" class="dropzone cb r7"></div>
            <div id="b8" class="dropzone cb r8"></div>

            <div id="c1" class="dropzone cc r1"></div>
            <div id="c2" class="dropzone cc r2"></div>
            <div id="c3" class="dropzone cc r3"></div>
            <div id="c4" class="dropzone cc r4"></div>
            <div id="c5" class="dropzone cc r5"></div>
            <div id="c6" class="dropzone cc r6"></div>
            <div id="c7" class="dropzone cc r7"></div>
            <div id="c8" class="dropzone cc r8"></div>
            
            <div id="d1" class="dropzone cd r1"></div>
            <div id="d2" class="dropzone cd r2"></div>
            <div id="d3" class="dropzone cd r3"></div>
            <div id="d4" class="dropzone cd r4"></div>
            <div id="d5" class="dropzone cd r5"></div>
            <div id="d6" class="dropzone cd r6"></div>
            <div id="d7" class="dropzone cd r7"></div>
            <div id="d8" class="dropzone cd r8"></div>
            
            <div id="e1" class="dropzone ce r1"></div>
            <div id="e2" class="dropzone ce r2"></div>
            <div id="e3" class="dropzone ce r3"></div>
            <div id="e4" class="dropzone ce r4"></div>
            <div id="e5" class="dropzone ce r5"></div>
            <div id="e6" class="dropzone ce r6"></div>
            <div id="e7" class="dropzone ce r7"></div>
            <div id="e8" class="dropzone ce r8"></div>
            
            <div id="f1" class="dropzone cf r1"></div>
            <div id="f2" class="dropzone cf r2"></div>
            <div id="f3" class="dropzone cf r3"></div>
            <div id="f4" class="dropzone cf r4"></div>
            <div id="f5" class="dropzone cf r5"></div>
            <div id="f6" class="dropzone cf r6"></div>
            <div id="f7" class="dropzone cf r7"></div>
            <div id="f8" class="dropzone cf r8"></div>
            
            <div id="g1" class="dropzone cg r1"></div>
            <div id="g2" class="dropzone cg r2"></div>
            <div id="g3" class="dropzone cg r3"></div>
            <div id="g4" class="dropzone cg r4"></div>
            <div id="g5" class="dropzone cg r5"></div>
            <div id="g6" class="dropzone cg r6"></div>
            <div id="g7" class="dropzone cg r7"></div>
            <div id="g8" class="dropzone cg r8"></div>
            
            <div id="h1" class="dropzone ch r1"></div>
            <div id="h2" class="dropzone ch r2"></div>
            <div id="h3" class="dropzone ch r3"></div>
            <div id="h4" class="dropzone ch r4"></div>
            <div id="h5" class="dropzone ch r5"></div>
            <div id="h6" class="dropzone ch r6"></div>
            <div id="h7" class="dropzone ch r7"></div>
            <div id="h8" class="dropzone ch r8"></div>
        </div>
        
        <div id="white-pieces">
            <img id="wK" class="draggable" src="<?=$setFolder?>/wK.png" alt="White King" title="White King" />
            <img id="wQ" class="draggable" src="<?=$setFolder?>/wQ.png" alt="White Queen" title="White Queen" />
            <img id="wB" class="draggable" src="<?=$setFolder?>/wB.png" alt="White Bishop" title="White Bishop" />
            <img id="wN" class="draggable" src="<?=$setFolder?>/wN.png" alt="White Knight" title="White Knight" />
            <img id="wR" class="draggable" src="<?=$setFolder?>/wR.png" alt="White Rook" title="White Rook" />
            <img id="wP" class="draggable" src="<?=$setFolder?>/wP.png" alt="White Pawn" title="White Pawn" />
            <img id="X" class="draggable" src="<?=$setFolder?>/X.png" alt="Marker - cross" title="Marker - cross" />
        </div>
    
    </div>
    
    <p>&nbsp;</p>
    
    <form id="get-image-form" action="chessdiagram.php" method="get">
        <input type="hidden" name="w" value="Kd5,Be3,g6" />
        <input type="hidden" name="b" value="Kf8,e7,h7" />
        <button type="button" onclick="clearBoard()"><img src="images/clear.png"/> Clear</button>
        <button type="button" onclick="resetBoard()"><img src="images/reset.png"/> Reset</button>
        <button type="button" onclick="toggleEnterPositions()"><img src="images/enter.png"/> Enter</button>
        <button type="submit" onclick="readPositions()"><img src="images/get.png"/> Get Image</button>
    </form>
    
    <form id="position-editor">
        White: <input type="text" name="w" value=""/> <br />
        Black: <input type="text" name="b" value=""/> <br />
        <button type="button" onclick="enterPositions()">Enter</button>
    </form>
    
</body>
</html>
