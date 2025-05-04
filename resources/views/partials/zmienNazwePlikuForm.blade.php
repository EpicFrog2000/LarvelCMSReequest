
// TODO DONT MOVE TO route
<div class="zmienNazwePlikuForm window" id="zmienNazwePlikuForm">
  <form class="adminForm" action="{{ route('changeName') }}" method="POST">
    @csrf
    <label class="adminFormLabel" for="newName">Nowa nazwa:</label>
    <input class="admintextInput" type="text" id="newName" name="newName">
    <input type="hidden" name="path" value="" id="currentName">
    <button class="adminButton" type="submit">Submit</button>
  </form>
</div>