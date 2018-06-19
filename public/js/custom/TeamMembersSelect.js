var $teamSelect = $('#created_by_team_id');
var $memberSelect = $('#created_by_id');

$teamSelect.change(function(event) {
  var teamID = event.target.value;
  if (!teamID) {
    $memberSelect.empty().select2({ data: [{id: null, text: 'Select team'}] });
    $memberSelect.attr('disabled', 'disabled');
    return;
  }

  $.get('/api/v1/team-members/' + teamID)
    .success(function(response) {
      $memberSelect.empty().select2({ data: formatResponsesFromSelect2(response) });
      $memberSelect.removeAttr('disabled');
    })
    .fail(function(e, data) {
      console.log(e, data)
    })
});

function formatResponsesFromSelect2(data) {
  return data.map(function(item) {
    return {
      id: item.id,
      text: item.name
    };
  });
}