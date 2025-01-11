<?php
session_start();
?>

<style>
  /* From Uiverse.io by andrew-demchenk0 */ 
.warning {
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  width: 100%;
  padding: 12px;
  background: #FEF7D1;
  border: 1px solid #F7C752;
  border-radius: 8px;
  box-shadow: 0px 0px 5px -3px #111;
}
.warming-content{
  display: flex;
  flex-direction: row;
  align-items: self-start;
  justify-content: flex-start;
  width: 100%;
}
.warning__icon {
  width: 20px;
  height: 20px;
  transform: translateY(-2px);
  margin-right: 8px;
}

.warning__icon path {
  fill: #F7C752;
}

.warning__title{
  width: 80%;
  font-weight: 500;
  font-size: 14px;
  color: #755118;
  
}

.warming__date {
  width: 80%;
  font-size: 9px;
  color: #755118;
  padding-left: 27px;
  font-style: italic;
}

.warning__close {
  width: 20px;
  height: 20px;
  margin-left: auto;
  cursor: pointer;
}

.warning__close path {
  fill: #755118;
}

.warmings{
  display: flex;
  flex-direction: column;
  gap: 10px;
}
/* From Uiverse.io by alexruix */ 
.group1 {
  display: flex;
  line-height: 28px;
  align-items: center;
  justify-content:space-between;
  min-width: 400px;
  position: relative;
}

.input {
  height: 40px;
  line-height: 28px;
  padding: 0 1rem;
  width: 500px;
  padding-left: 2.5rem;
  border: 2px solid transparent;
  border-radius: 8px;
  outline: none;
  background-color: #D9E8D8;
  color: #0d0c22;
  box-shadow: 0 0 5px #C1D9BF, 0 0 0 10px #f5f5f5eb;
  transition: 0.3s ease-in-out;
}


.search-store:focus {
    border-color: #4CAF50;
}

.input::placeholder {
  color: #777;
}

.icon {
  fill: #777;
  width: 1rem;
  height: 1rem;
  position: absolute;
  right: 1.5rem;
  cursor:pointer;
}

/*#containterFilter{
  display: flex;
  justify-content: flex-end;
  max-height: 0;  Pas de hauteur visible 
  display: none; 
  transition: max-height 0.4s ease-out; 
  border-radius: 5px;
  padding: 0 10px;
}*/
#containterFilter{
  display: flex;
  justify-content: center;
  max-height: 0; /* Pas de hauteur visible */
  overflow: hidden; /* Masque le contenu qui dépasse */
  transition: max-height 0.4s ease-out; /* Animation d'ouverture */
  border-radius: 5px;
  padding: 0 10px;
}
#containterFilter.active {
  min-height: 230px; /* Ajustez la hauteur maximale en fonction du contenu */
}

#elementsFilter{
  width: 490px;
  min-height: 100px;
  ine-height: 28px;
  padding: 1rem;
  border: 2px solid transparent;
  border-radius: 8px;
  background-color:#D9E8D8 ;
  /*float: right;*/
  margin-right: 80px;
  display: flex;
  flex-direction:column;
  gap: 10px;
}

/* From Uiverse.io by Yaya12085 */ 
.radio-inputs {
  position: relative;
  display: flex;
  flex-wrap: wrap;
  border-radius: 0.5rem;
  background-color: #fff;
  box-sizing: border-box;
  box-shadow: 0 0 0px 1px rgba(0, 0, 0, 0.06);
  padding: 0.25rem;
  width: 300px;
  font-size: 14px;
}

.radio-inputs .radio {
  flex: 1 1 auto;
  text-align: center;

}

.radio-inputs .radio input {
  display: none;
}

.radio-inputs .radio .name {
  display: flex;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  border-radius: 0.5rem;
  border: none;
  padding: .5rem 0;
  color: rgba(51, 65, 85, 1);
  transition: all .15s ease-in-out;
}
/*P080417288189N  785894 */
.radio-inputs .radio input:checked + .name {
  background-color: #fff;
  font-weight: 600;
}

.divFilter{
  display: flex;
  gap: 5px;
  justify-content: space-around;
}
label{
  margin: 0;
  font-weight: unset;
}


</style>
<div class="header">
      <h1>Welcome Back <?php echo $_SESSION['nom'] ;?> </h1>
      <div class="header-right">
        <div class="notification-container" id="alertClick">
          <span  class="notification-icon">🔔</span>
          <span class="notification-count">1</span> <!-- Remplacez '1' par le nombre dynamique de notifications -->
        </div>
      </div>
</div>

<div id="alertModal" class="modal">
        <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Alerts</h2>
        
        <!-- Formulaire avec les champs du magasin, date, commercial et OK -->
        <div class="warmings" style="margin-top:5px">
          <div class="warning">
            <div class="warming-content">
              <div class="warning__icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none"><path fill="#393a37" d="m13 14h-2v-5h2zm0 4h-2v-2h2zm-12 3h22l-11-19z"></path></svg>
              </div>
                <div class="warning__title" style="margin:0">message</div>
                <!--<div class="warning__close"><svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" height="20"><path fill="#393a37" d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z"></path></svg></div>
-->
              </div>
              <div class="warming__date">12/12/2024</div>
          </div>
        </div>
        </div>
</div>  

