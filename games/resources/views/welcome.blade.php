<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{asset('assets/css/app.css')}}" rel="stylesheet">

        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    </head>
    <body>

        <div class="w-25 p-1">
           
            <label for="selectTheBoard">Select borad</label>

            <select class="form-control" onchange="selectBoard(this)" id="selectTheBoard">
                <option value="3" <?= $type ==3 ? 'selected' : '' ?> >3 * 3 </option>
                <option value="4" <?= $type ==4 ? 'selected' : '' ?>>4 * 4 </option>
                <option value="5" <?= $type ==5 ? 'selected' : '' ?>>5 * 5 </option>
                <option value="6" <?= $type ==6 ? 'selected' : '' ?>>6 * 6 </option>
                <option value="7" <?= $type ==7 ? 'selected' : '' ?>>7 * 7 </option>
                <option value="8" <?= $type ==8 ? 'selected' : '' ?>>8 * 8 </option>
                <option value="9" <?= $type ==9 ? 'selected' : '' ?>>9 * 9 </option>
                <option value="10" <?= $type ==10 ? 'selected' : '' ?>>10 * 10 </option>
            </select>

        </div>

        <div id='theBord'>
            {!! $page !!}
        </div>
    </body>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                    <div data-winning-message-text></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" id="restartButton" onclick="startGame()" data-bs-dismiss="modal">Restart</button>
              
            </div>
          </div>
        </div>
    </div>



    <script>

      

    const X_CLASS = 'x'
    const CIRCLE_CLASS = 'circle'

    var WINNING_COMBINATIONS = <?php echo json_encode($combination); ?>;
    
    const cellElements = document.querySelectorAll('[data-cell]')
    const board = document.getElementById('board')
    const winningMessageElement = document.getElementById('winningMessage')
    const restartButton = document.getElementById('restartButton')
    const winningMessageTextElement = document.querySelector('[data-winning-message-text]')
    let circleTurn

    startGame()

    restartButton.addEventListener('click', startGame)

    function startGame() {
    circleTurn = false
    cellElements.forEach(cell => {
        cell.classList.remove(X_CLASS)
        cell.classList.remove(CIRCLE_CLASS)
        cell.removeEventListener('click', handleClick)
        cell.addEventListener('click', handleClick, { once: true })
    })
    setBoardHoverClass()
    winningMessageElement.classList.remove('show')
    }

    function handleClick(e) {
        console.log("WINNING_COMBINATIONS 2 " , WINNING_COMBINATIONS);
    const cell = e.target
    const currentClass = circleTurn ? CIRCLE_CLASS : X_CLASS
    placeMark(cell, currentClass)
    if (checkWin(currentClass)) {
        endGame(false)
    } else if (isDraw()) {
        endGame(true)
    } else {
        swapTurns()
        setBoardHoverClass()
    }
    }

    function endGame(draw) {
    if (draw) {
        $("#exampleModal").modal('show');
        winningMessageTextElement.innerText = 'Draw!'
    } else {
        $("#exampleModal").modal('show');
        winningMessageTextElement.innerText = `${circleTurn ? "O's" : "X's"} Wins!`
    }
    winningMessageElement.classList.add('show')
    }

    function isDraw() {
    return [...cellElements].every(cell => {
        return cell.classList.contains(X_CLASS) || cell.classList.contains(CIRCLE_CLASS)
    })
    }

    function placeMark(cell, currentClass) {
    cell.classList.add(currentClass)
    }

    function swapTurns() {
    circleTurn = !circleTurn
    }

    function setBoardHoverClass() {
    board.classList.remove(X_CLASS)
    board.classList.remove(CIRCLE_CLASS)
    if (circleTurn) {
        board.classList.add(CIRCLE_CLASS)
    } else {
        board.classList.add(X_CLASS)
    }
    }

    function checkWin(currentClass) {
    return WINNING_COMBINATIONS.some(combination => {
        return combination.every(index => {
        return cellElements[index].classList.contains(currentClass)
        })
    })
    }

    

    </script>


    <script>
        function selectBoard(e) {
            window.location.href = window.location.origin + window.location.pathname + '?boradType=' +e.value;
         }
    </script>
</html>
