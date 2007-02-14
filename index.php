<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Chess Diagram Creator</title>
    <link rel="stylesheet" type="text/css" href="chessdiagram.css" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/iutil.js"></script>
    <script type="text/javascript" src="js/idrag.js"></script>
    <script type="text/javascript" src="js/idrop.js"></script>
    <script type="text/javascript">
    var movingNow;
    
    function getCellImgSrc(cellId, pieceSrc)
    {
        var row = parseInt(cellId[1]);
        var col = cellId.charCodeAt(0) - "a".charCodeAt(0) + 1;
        
        var background = (col + row) % 2 == 1 ? 'w' : 'b';
        
        var backgroundPos = pieceSrc.length - 7;
        
        return pieceSrc.substring(0, backgroundPos) + background + pieceSrc.substring(backgroundPos + 1);
    }
    
    function pieceDropped(drag)
    {
        var imgSelector = "#" + this.id + " img";
        $(imgSelector).remove();
        
        var imgTag = "<img class='draggable' src='" + getCellImgSrc(this.id, drag.src) + "' alt='" + drag.alt + "' title='" + drag.title + "' />";
        
        $(this).append(imgTag);
        
        if (drag.id == "")
        {
            $(drag).remove();
        }
        
        $(imgSelector).Draggable(
            {
                revert:  true,
                onStart: pieceMoveStarted,
                onStop:  pieceMoveStopped
            }
        );
        
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
            var pieceCodes = new Array('K', 'Q', 'B', 'N', 'R', 'P');
            
            for (i = 0; i < colorCodes.length; i++)
            {
                var colorCode = colorCodes[i];
                
                for (j = 0; j < pieceCodes.length; j++)
                {
                    var pieceCode = pieceCodes[j];
                    var pieceId = '#' + colorCode + pieceCode;
                    
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
    </script>
</head>
<body>
    
    <h1>Chess Diagram Creator</h1>
    
    <form action="chessdiagram.php" method="get">
        <table>
            <tr>
                <td>White</td>
                <td><input type="text" name="w" value="Kd5,Be3,g6" /></td>
            </tr>
            <tr>
                <td>Black</td>
                <td><input type="text" name="b" value="Kf8,e7,h7" /></td>
            </tr>
        </table>
        <input type="submit" value="Get Image" />
    </form>
    
    <h1>Drag-and-Drop</h1>
    
    <div id="drag-drop-area">
        
        <div id="black-pieces">
            <img id="bK" class="draggable" src="default/wbK.png" alt="Black King" title="Black King" />
            <img id="bQ" class="draggable" src="default/wbQ.png" alt="Black Queen" title="Black Queen" />
            <img id="bB" class="draggable" src="default/wbB.png" alt="Black Bishop" title="Black Bishop" />
            <img id="bN" class="draggable" src="default/wbN.png" alt="Black Knight" title="Black Knight" />
            <img id="bR" class="draggable" src="default/wbR.png" alt="Black Rook" title="Black Rook" />
            <img id="bP" class="draggable" src="default/wbP.png" alt="Black Pawn" title="Black Pawn" />
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
            <img id="wK" class="draggable piece" src="default/wwK.png" alt="White King" title="White King" />
            <img id="wQ" class="draggable" src="default/wwQ.png" alt="White Queen" title="White Queen" />
            <img id="wB" class="draggable" src="default/wwB.png" alt="White Bishop" title="White Bishop" />
            <img id="wN" class="draggable" src="default/wwN.png" alt="White Knight" title="White Knight" />
            <img id="wR" class="draggable" src="default/wwR.png" alt="White Rook" title="White Rook" />
            <img id="wP" class="draggable" src="default/wwP.png" alt="White Pawn" title="White Pawn" />
        </div>
    
    </div>
    
</body>
</html>
