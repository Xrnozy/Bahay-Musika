<html>
    <head>
    <style>     
        *{
            padding: 0; 
            margin: 0;   
        }    
        .inputs {
            margin-bottom: 20px;
        }   
        textarea {
            height: 80px;
            width: 100%;
        }
        div{
            padding: 0 10px 0 10px;
            padding-top: 50px;
            background-color: gray;
        }
        .reset{
            margin-bottom: 5px;
        }
         </style>
    </head>
    <body>
        <div>
        <center><h1>My First HTML Form</h1> </center>
        <form action="assignment1_output.php" method="post">
            <label>Firstname:</label> <input type="text" name="firstname" class="inputs"/> <br>
            <label>Middlename:</label> <input type="text" name="middlename" class="inputs"/>  <br>
            <label>Lastname:</label> <input type="text" name="lastname" class="inputs"/> <br>
            <label>Course:</label>
            <select name="course">
                <option value="" selected="selected">Course</option>
                <option value="Computer Science">Computer Science</option>
                <option value="Information Technology">Information Technology</option>
                <option value="Others">Others</option>
            </select> <br> <br>
            
            <label>Gender:</label> <br>
            <input type="radio" name="gender" value="male"> Male </input> <br>
            <input type="radio" name="gender" value="female"> Female </input> <br>
            <input type="radio" name="gender" value="other"> Other </input> <br> <br>
            
            <label>Phone: </label>
                <input type="text" name="phone1" value="+63" size="3"/> 
                <input type="tel" name="phone2" class="inputs"/>  <br>

            <label>Address:</label> <br> <textarea name="address"> </textarea> <br>

            <button> Submit </button>
            <button class="reset" type="reset"> Reset </button>
        </form>
        </div>
    </body>
</html>