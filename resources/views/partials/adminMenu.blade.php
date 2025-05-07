<div style="display: flex; flex-direction: row; width: auto; text-wrap-mode: nowrap;" id="adminMenu" class="conextMenu">
  <div class="adminTab">
    <div class="contextMenuOption dropdownOptions">
      <button class="adminTabLinks">Ustawienia Elementu</button>
      <div id="UstawieniaElementu" class="tabcontent" style="display: none;"></div>
    </div>

    {{-- TO DO DODANIA KOLEJNE OPCJE W MENU --}}
    {{-- <div class="contextMenuOption">
      <button class="adminTabLinks">Ustawienia Elementu</button>
      <div id="UstawieniaElementu" class="tabcontent"></div>
    </div> --}}

    <div class="contextMenuOption">
      <button class="adminTabLinks" id="ZarzadzaniePlikami" onclick="window.zarzadzaniePlikamiWindow.showWindowElement()">Zarządzanie plikami</button>
    </div>

    <div class="contextMenuOption">
      <button class="adminTabLinks" id="Logout" onclick="window.location.href = window.location.origin + '?logout';">Logout</button>
    </div>

  </div>

  <div id="ListaElementów" class="adminTab" style="background-color: #f1f1f1; display: none;"></div>
  <div id="ListaContainerów" class="adminTab" style="background-color: #f1f1f1; display: none;"></div>
</div>


<div style="position: fixed; right: 20px; bottom: 20px;">
  <button class="adminButton" id="saveWyswigButton">ZAPISZ</button>
</div>