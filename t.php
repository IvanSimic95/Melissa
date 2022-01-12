
<div class="form">
	
	<header class="form__header">
		<h2 class="form__title">Awesome Form</h2>
		<p class="form__instruction">Hey there! Let’s get to know each other. Please select one of the options below each question :D</p>
	</header>
	
	<form>
		<fieldset class="form__options">
			<legend class="form__question">What is your ideal match?
</legend>
			<p class="form__answer"> 
				<input type="radio" name="match" id="match_1" value="guy" checked> 
				<label for="match_1">
					<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <title>Icon Guy</title>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="Guy" stroke="#FFFFFF" stroke-width="2">
            <path d="M50,89 C28.4608948,89 11,71.5391052 11,50 C11,28.702089 28.8012779,11 50,11 C71.3811739,11 89,28.8647602 89,50 C89,71.5391052 71.5391052,89 50,89 Z" id="Oval"></path>
            <path d="M34.5,59 C32.0147186,59 30,56.9852814 30,54.5 C30,53.1996039 30.5532818,51.9907899 31.5049437,51.1414086 C32.3241732,50.4102265 33.3788668,50 34.5,50 C36.9852814,50 39,52.0147186 39,54.5 C39,56.9852814 36.9852814,59 34.5,59 Z" id="eye"></path>
            <path d="M65,59 C62.790861,59 61,57.209139 61,55 C61,53.844 61.4917357,52.7696523 62.3377558,52.0145589 C63.0660084,51.3645758 64.0033341,51 65,51 C67.209139,51 69,52.790861 69,55 C69,57.209139 67.209139,59 65,59 Z" id="eye"></path>
            <path d="M13,39 C13,39 18.3404984,39.6508711 28,35 C37.6595016,30.3491289 40,26 40,26 C40,26 50.99493,36.4771587 58,38 C65.00507,39.5228413 75,42 86,36" id="Path-9"></path>
            <path d="M40.0417765,73.6204199 C43.0857241,74.4024099 46.5428621,75 50,75 C53.4660267,75 57.0521869,74.3993329 60.2588177,73.6143844" id="Path-8"></path>
        </g>
    </g>
</svg>
					Guy
				</label> 
			</p>
			
			<p class="form__answer"> 
				<input type="radio" name="match" id="match_2" value="girl"> 
				<label for="match_2">
					<img src="assets/img/woman.png">
					Girl
				</label> 
			</p>
			
			
			
		</fieldset>
		<button class="form__button" type="submit">Submit your info</button>
	</form>
</div>

<footer>
	<h2 class="footer__title">About this pen:</h2>
	<h3 class="footer__subtitle">Properly styling a form</h3>
	<p class="footer__parragraph">I made this pen to practice writing more semantic and accesible html. I previously made a pen about: <a target="_blank" href="https://codepen.io/AngelaVelasquez/full/Eypnq/">CSS Radio buttons</a>. That's why I think a form could be a great start for me to practice and learn how to write better HTML.</p>
	
	<p class="footer__parragraph">References:</p>
	
	<ul class="footer__list">
		<li><a target="_blank" href="https://developer.mozilla.org/en-US/docs/Learn/HTML/Forms/How_to_structure_an_HTML_form">Definitions and usage on MDN</a></li>
		<li><a target="_blank" href="https://codepen.io/SaraSoueidan/pen/40433575e3d0d026c7d9c00eb45522a1?editors=110">Styling checkboxes with SVG by Sara Soueidan</a></li>
	</ul>

	<p class="copyright">Awesome pen made by <a target="_blank" href="https://codepen.io/AngelaVelasquez">Angela</a></p>
</footer>
<style>
/* Font from Google fonts */
@import url("https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,900");
/* Color palette */
/* Basic styles */
html, body {
  height: 100%;
  font-family: "Source Sans Pro", sans-serif;
  background-color: #00171F;
  color: #FAFAFA;
}

/* Form Styles */
.form {
  max-width: 610px;
  margin: 60px auto;
}

.form__header {
  margin-bottom: 40px;
  border-bottom: 1px dashed rgba(250, 250, 250, 0.15);
}

.form__title {
  font-size: 45px;
  margin: 10px 0;
}

.form__instruction {
  font-size: 22px;
}

.form__options {
  border: none;
  padding: 0;
}

.form__question {
  font-size: 25px;
}

.form__answer {
  display: inline-block;
  box-sizing: border-box;
  width: 23%;
  margin: 20px 1% 20px 0;
  height: 180px;
  vertical-align: top;
  font-size: 22px;
  text-align: center;
}

label {
  border: 1px solid rgba(250, 250, 250, 0.15);
  box-sizing: border-box;
  display: block;
  height: 100%;
  width: 100%;
  padding: 10px 10px 30px 10px;
  cursor: pointer;
  opacity: 0.5;
  transition: all 0.5s ease-in-out;
}
label:hover, label:focus, label:active {
  border: 1px solid rgba(250, 250, 250, 0.5);
}

.form__button {
  height: 40px;
  border: none;
  background-color: #00703f;
  color: #FAFAFA;
  text-transform: uppercase;
  font-family: "Source Sans Pro", sans-serif;
  padding: 0 20px;
  border-radius: 20px;
  font-weight: 900;
  cursor: pointer;
  margin: 40px 0;
  transition: all 0.25s ease-in-out;
}
.form__button:hover, .form__button:focus {
  background-color: #00824A;
  text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.25);
  outline: none;
}

/* Input style */
input[type=radio] {
  opacity: 0;
  width: 0;
  height: 0;
}

input[type=radio]:active ~ label {
  opacity: 1;
}

input[type=radio]:checked ~ label {
  opacity: 1;
  border: 1px solid #FAFAFA;
}

/* Footer Styles */
footer {
  background-color: #003459;
  position: relative;
  padding: 20px;
}
footer h2, footer h3, footer p, footer ul {
  max-width: 610px;
  margin: 20px auto;
}

.footer__title {
  font-size: 30px;
  margin-top: 40px;
  color: #00171F;
}

.footer__subtitle {
  font-size: 22px;
}

.footer__parragraph, .copyright, .footer__list {
  line-height: 1.5em;
  font-size: 22px;
}
.footer__parragraph a, .copyright a, .footer__list a {
  color: #00A7E1;
}

.copyright {
  text-align: center;
  border-top: 1px dashed rgba(250, 250, 250, 0.15);
  padding: 10px 0;
  margin: 40px auto;
}
    </style>