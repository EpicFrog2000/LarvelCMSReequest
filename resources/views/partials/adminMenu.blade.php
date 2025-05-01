<div style="display: flex; flex-direction: row; width: auto; text-wrap-mode: nowrap;" id="adminMenu">
  <div class="tab">
    <div class="adminMenuOptionMain dropdownOptions">
      <button class="tablinks">Ustawienia Elementu</button>
      <div id="UstawieniaElementu" class="tabcontent" style="display: none;"></div>
    </div>


    {{-- TO DO DODANIA KOLEJNE OPCJE W MENU --}}
    {{-- <div class="adminMenuOptionMain">
      <button class="tablinks">Ustawienia Elementu</button>
      <div id="UstawieniaElementu" class="tabcontent"></div>
    </div> --}}


    <div class="adminMenuOptionMain">
      <button class="tablinks" id="Logout" onclick="window.location.href = window.location.origin + '?logout';">Logout</button>
    </div>

  </div>

  <div id="ListaElementów" class="tab" style="background-color: #f1f1f1; display: none;"></div>
  <div id="ListaContainerów" class="tab" style="background-color: #f1f1f1; display: none;"></div>
</div>


<div style="position: fixed; right: 20px; bottom: 20px;">
  <button class="save-button" onclick="zapiszWyswig()">ZAPISZ</button>
</div>