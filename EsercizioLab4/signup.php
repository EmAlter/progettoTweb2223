<?php include "top.html"; ?>

<!--
    Pagina di creazione nuovo account,
    i dati vengoni inviati con il metodo POST al documento signup-submit.php.
    Ogni tag <label> contiene un diverso <input> per i dati da memorizzare
 -->

<form action="signup-submit.php" method="POST">
    <fieldset class="column">
        <legend>New User Signup</legend>
        <strong>Name:</strong>              <label><input type="text" size="16" name="name"></label><br> 
        <strong>Gender:</strong>            <label><input type="radio" name="gender" value="male">Male</label>
                                            <label><input type="radio" name="gender" value="female" checked="checked">Female</label><br> <!-- con checked viene impostato come predefinito "Female"-->
        <strong>Age:</strong>               <label><input type="text" size="6" maxlength="2" name="age"></label><br>
        <strong>Personality type:</strong>  <label><input type="text" size="6" maxlength="4" name="ptype">
                                                    <a class="link" href="http://www.humanmetrics.com/cgi-win/JTypes2.asp">(Don't know your type?)</a></label><br>
        <strong>Favorite OS:</strong>        <label><select name="favOS">
                                                        <option>Windows</option>
                                                        <option selected="selected">Linux</option> <!-- con selected viene impostato come predefinito "Linux"-->
                                                        <option>Mac OS X</option>
                                                    </select>
                                            </label><br>
        <strong>Seeking age:</strong>       <label><input type="text" size="6" maxlength="2" name="ageMin" placeholder="min"></label> to
                                            <label><input type="text" size="6" maxlength="2" name="ageMax" placeholder="max"></label><br>
                                            <label><input type="submit" name="submit" value="Sign Up"></label>
    </fieldset>
</form>
<?php include "bottom.html"; ?>