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

</style>
<div class="header">
      <h1>Welcome Back</h1>
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

