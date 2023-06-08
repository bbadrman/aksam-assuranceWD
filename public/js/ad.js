

// START Fetching Users Active //
window.onload = () => {
	 
	let activer = document.querySelectorAll("[type=checkbox]")
	for(let bouton of activer){
		bouton.addEventListener("click", function(){
			let xmlhttp = new XMLHttpRequest;

			xmlhttp.open("get", `/utilisateurs/activer/${this.dataset.id}`)
			xmlhttp.send();
			
		})
	}
}



	// START Fetching Groups //
	function fetchGroups() {
		$.ajax({
		type: "GET",
		url: "/team",
		dataType: "json",
		success: function (response) {
		let listGroups = '';
		
		$.each(response.team, function (key, item) {
		listGroups += `<tr>
											<td>${
		item.id
		}</td>
											<td>${
		item.name
		}</td>
											<td>${
		item.description
		}</td>
											<td class="btn-toolbar">
											<button href="#"  value="${
		item.id
		}" class="show_groupe btn btn-success btn-xs"> <i class="fa fa-eye"></i></button>
											<button href="#"  value="${
		item.id
		}" class="edit_groupe btn btn-primary btn-xs"> <i class="fa fa-pencil"></i></button>
											<button href="#"  value="${
		item.id
		}" class="delete_groupe btn btn-danger btn-xs"> <i class="fa fa-trash"></i></button>
											</td>
										</tr>`;
		});
		groupList.html(listGroups);
		}
		});
		}
		// END Fetching Groups //
		
		// START Adding a Team //
		
		$(document).on('click', '.team_new', function (e) {
		e.preventDefault();
		const data = {
		'name': $('#team_name').val(),
		
		'description': $('.description').val(),
		};
		
		let AddGroupModal = $('#AddGroupeModal');
		
		$.ajax({
		type: "POST",
		url: "/team/new-team",
		data: data,
		dataType: "json",
		success: function (response) {
			
			if (response.status === 400) {
			$('#saveform_errList').html("").addClass('alert alert-danger');
			$.each(response.errors, function (key, err_values) {
			$('#saveform_errList').append('<li>' + err_values + '</li>');
			

			});
			} else {
			$('#saveform_errList').html("").removeClass('alert alert-danger');
			$('#success_message').addClass('alert alert-success').text(response.message);
			$('#user_teams').append('<option value="1" selected="selected">'+ $('#team_name').val() +'</option>');
			AddGroupModal.modal('hide').find('#team_name').val("").find('#team_description').val("");
			
			fetchGroups();
		}
		// window.location.reload();
	}
		})
		});

		// END Adding a Team //


		// START adding a Product //
		
		$(document).on('click', '.product_new', function (e) {
			e.preventDefault();
			
			const data = {
				'name': $('#product_name').val(),
				
				'descrption': $('.descrption').val()
			};
			
			let AddProductModal = $('#AddProductModal');
			
			$.ajax({
				type: "POST",
				url: "/product/new-product",
				data: data,
				dataType: "json",
				success: function (response) {
					if (response.status === 400) {
						$('#saveform_errList').html("").addClass('alert alert-danger');
						$.each(response.errors, function (key, err_values) {
						$('#saveform_errList').append('<li>' + err_values + '</li>');
						});
					} else {
						$('#saveform_errList').html("").removeClass('alert alert-danger');
						$('#success_message').addClass('alert alert-success').text(response.message);
						$('#user_products').append('<option value="1" selected="selected">'+ $('#product_name').val() +'</option>');
						AddProductModal.modal('hide').find('#product_name').val("").find('#product_descrption').val("");			
						 
			    	}
			     }
			  })
			});
	
	   // END adding a Product //


		// START adding a Fonction //
		
		$(document).on('click', '.fonction_new', function (e) {
			e.preventDefault();
			
			const data = {
				
				'name': $('#fonction_name').val(),
				'description': $('.description').val()
				// 'description': $('.description').val()
			};
			// console.log(data);
			
			let AddFonctionModal = $('#AddFonctionModal');
			
			$.ajax({
				type: "POST",
				url: "/fonctions/new-fonction",
				data: data,
				dataType: "json",
				success: function (response) {
					// console.log(response);
					if (response.status === 400) {
						$('#saveform_errList').html("").addClass('alert alert-danger');
						$.each(response.errors, function (key, err_values) {
							console.log(response);
						$('#saveform_errList').append('<li>' + err_values + '</li>');
						});
					} else {
						$('#saveform_errList').html("").removeClass('alert alert-danger');
						$('#success_message').addClass('alert alert-success').text(response.message);
						$('#user_fonctions').append('<option value="1" selected="selected">'+ $('#fonction_name').val() +'</option>');
						AddFonctionModal.modal('hide').find('#fonction_name').val("").find('#fonction_description').val("");			
						 
			    	}
			     }
			  })
			});
	
	   // END adding a Fonction //

	 


 

		
	 

// $(document).ready(function() {
// 	var $locationSelector = $('user_teams');
// 	var $specificLocationTarget = $('user_products');

// 	$locationSelector.on('change', function(e){
// 		$.ajax({
// 			url: $locationSelector.data('specification'),
// 			data: {
// 				location: $locationSelect.val()
// 			},
// 			success: function(html) {
// 				if(!html){
// 					$specificLocationTarget.find('select').remove();
// 					$specificLocationTarget.addClass('d-none');

// 					return;
// 				}

// 				$specificLocationTarget
// 				.html(html)
// 				.removeClass('d-none');
// 			}
// 		});
// 	});
// });

 
// pour cache le tableau prospect
// $(document).ready(function() {
//     $("#shrch").hide();  // masquer la div au chargement de la page
//     $("#searchBtn").click(function() {  // ajouter un écouteur d'événements sur le bouton de recherche
//         $("#shrch").show();  // afficher la div lorsque le bouton de recherche est cliqué
//     });
// });

// $('document').ready(function() {
// 	$("#shrch").hide() 
        
//  });

 //select dynamique

 
document.addEventListener('DOMContentLoaded', function() {
    const teamSelectEl = document.getElementById('prospect_team');
    teamSelectEl.addEventListener('change', function(e) {
		console.log('okok');
        const formEl = teamSelectEl.closest('form');
		
        fetch(formEl.action, {
            method: formEl.method,
            body: new FormData(formEl)
        })
        .then(response => response.text())
        .then(html => {

			
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newComrclFormFieldEl = doc.getElementById('prospect_comrcl');
		 
			console.log(newComrclFormFieldEl);
            
				console.log('select');
                newComrclFormFieldEl.addEventListener('change', function(e) {
                    e.target.classList.remove('is-invalid');
                });
                document.getElementById('prospect_comrcl').replaceWith(newComrclFormFieldEl);
             
        })
        .catch(function (err) {
            console.warn('Something went wrong.', err);
        });
    });
});



// select typeProspect

var categoryField = document.getElementById('prospect_typeProspect');
var subcategoryContainer = document.getElementById('subcategory-container');

if (categoryField !== null) {
    categoryField.addEventListener('change', function() {
        if (categoryField.value === 'Professionnels') {
			 
            subcategoryContainer.style.display = 'block';
        } else {
            subcategoryContainer.style.display = 'none';
        }
    });
}

 

//select motiveProspect
	var motifField = document.getElementById('prospect_source');
    var submotifContainer = document.getElementById('subMotiv-container');
	if (motifField !== null) {
    motifField.addEventListener('change', function() {
        if (motifField.value === 'Saisie manuelle') {
		 
            submotifContainer.style.display = 'block';
        } else {
            submotifContainer.style.display = 'none';
        }
    });
}
 
//select motiveResil
var resilField = document.getElementById('prospect_lastAssure');
var subresilContainer = document.getElementById('subResil-container');
if (resilField !== null) {
	resilField.addEventListener('change', function() {
	if (resilField.value === 'Oui') {
	 
		subresilContainer.style.display = 'block';
	} else {
		subresilContainer.style.display = 'none';
	}
});
}




//button dashbord
// function togglePanel() {
// 	var panel = document.getElementById('panell');
// 	if (panel.style.display === 'none') {
// 	  panel.style.display = 'table-row'; // ou 'block' si le parent est un tbody
// 	} else {
// 	  panel.style.display = 'none';
// 	}
// 	 var panel = document.getElementById('panel1');
// 	if (panel.style.display === 'none') {
// 	  panel.style.display = 'table-row'; // ou 'block' si le parent est un tbody
// 	} else {
// 	  panel.style.display = 'none';
// 	}
//   }


   
	// $(document).ready(function(){
	// $("#flipp").click(function(){
	// 	$("#panell").slideToggle("slow");
	// 	$("#panel1").slideToggle("slow");
	// });
	// });
 
