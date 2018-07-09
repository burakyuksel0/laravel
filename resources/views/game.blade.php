@extends("layouts.app")

@section("content")
<style>
    .mine-button {
        border-radius: 0px;
        width : 30px;
        height : 30px;
        margin : 2px;
        padding : 0px;
    }
    .btn-gray {
        background-color: darkgray;
        text-align: center;
    }
    .start-button {
        margin-bottom: 7px;
    }

</style>

<body>
    <div class="container">
        <div class="text-center" id="game">
            @for($i = 0; $i < 10; $i++)
                @for($j = 0; $j < 10; $j++)
                    <button class="mine-button btn btn-primary" id="{{10*$i+$j}}"></button>
                @endfor
                <br />
            @endfor
        </div>
        <br />
        <div class="text-center" id="menu">
            <button href="#" class="btn start-button btn-success">New Game</button>
            <br />
            <a href="{{url("/todos")}}" class="btn btn-danger">Back to Todo List</a>
        </div>
    </div>
</body>

<script>
    var matrix = new Array(100);
    var minesAround = new Array(100);
    var isClicked = new Array(100);
    var clicked;

    $("#game").hide();

    function remove_add(id, remove, add) {
        document.getElementById(id).classList.remove(remove);
        document.getElementById(id).classList.add(add);
    }

    $(".start-button").click(function() {
        matrix.fill(0);
        minesAround.fill(0);
        isClicked.fill(0);
        clicked = 0;


        for (var i=0; i<16; i++) {
            matrix[Math.floor(Math.random()*100)] = 1;
        }

        for (var k=0; k<100; k++) {
            $(".mine-button").text("");
            document.getElementById(k).classList.remove("btn-danger"); 
            document.getElementById(k).classList.remove("btn-warning");
            document.getElementById(k).classList.remove("btn-gray");
            document.getElementById(k).classList.add("btn-primary");
            document.getElementById(k).disabled = false;

            for (var i = (k<10)-1; i <= 1-(k>=90); i++) {
                for (var j = (k%10==0)-1; j <= 1-(k%10==9); j++) {
                    minesAround[k] += matrix[k+10*i+j];
                }
            }
        }

        $("#menu").hide();
        $("#game").show();
    });

    $(".mine-button").click(function() {
        var id = parseInt(this.getAttribute('id'));

        if (!isClicked[id]) {
            if (matrix[id] == 1) {
                for (var i = 0; i < 100; i++) {
                    if (matrix[i] == 1) {
                        remove_add(i, "btn-primary", "btn-danger");
                    }
                    document.getElementById(i).disabled = true;
                }
                alert("Game over!");
                $("#menu").show();
            }
            else {
                isClicked[id] = 1;
                clicked ++;
                remove_add(id, "btn-primary", "btn-gray");
                var queue = [id];

                while (queue.length>0) {
                    var cur = queue.shift();
                    document.getElementById(cur).innerHTML = "" + minesAround[cur];

                    if (minesAround[cur]==0) {

                        for (var i = (cur<10)-1; i <= 1-(cur>=90); i++) {
                            for(var j = (cur%10==0)-1; j <= 1-(cur%10==9); j++) {
                                if (!isClicked[cur+10*i+j]) {
                                    isClicked[cur+10*i+j] = 1;
                                    clicked ++;
                                    remove_add(cur+10*i+j, "btn-primary", "btn-gray");
                                    queue.push(cur+10*i+j);
                                }
                            }
                        }
                    }
                }

                if(clicked == 100) {
                    alert("Congrats, you win!");
                    $("#menu").show();
                    $("#game").hide();
                }
            }
        }
    });

    $(".mine-button").contextmenu(function() {
        var id = parseInt(this.getAttribute('id'));

        if (!isClicked[id]) {
            document.getElementById(id).innerHTML = "M";
            remove_add(id, "btn-primary", "btn-warning");
            isClicked[id] = 2;
            if (matrix[id])
                clicked ++;
        }
        else if (isClicked[id] == 2) {
            document.getElementById(id).innerHTML = "";
            remove_add(id, "btn-warning", "btn-primary");
            isClicked[id] = 0;
            if (matrix[id])
                clicked --;
        }
        
        if(clicked == 100) { 
            alert("Congrats, you win!");
            $("#menu").show();
            $("#game").hide();
        }
    
        return false;
    });

</script>

@endsection