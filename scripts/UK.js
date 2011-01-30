var UK = UK ? UK : {};

(function ($) {
	$(document).ready(function() {
		UK.$game = $('#game');
		UK.$field = UK.$game.find('#elements');
		UK.$result = UK.$game.find('#results');
		UK.defaults = {
			list: 'elementList',
			drop: 'dropZone'
		};

		UK.updateElementLists = function(e,ui) {
			UK.$result.hide();
			var $element = $(ui.item).find('a');
			var elements = UK.$field.val();
			if ($(ui.sender).attr('id') === UK.defaults.list) {
				if ($.trim(elements) === '') {
					UK.$field.val($element.attr('title'));
				} else {
					UK.$field.val(elements + ',' + $element.attr('title'));
				}
			} else {
				UK.$field.val(elements.replace(',' + $element.attr('title'), ''));
			}
		};

		UK.combineElements = function() {
			var comboUrl = '/inexact-scientist/element/combine';
			$.ajax({
				url: comboUrl,
				type: 'post',
				dataType: 'json',
				data: $('#'+UK.defaults.drop).sortable('serialize'),
				success: function(data, status, xhr) {
					var json = eval(data);
					var result = UK.addNewElement(json);
					if (result) {
						var msg = '';
						var length = result.length;
						for (var i = 0; i < length; i++) {
							if (length > 2) {
								msg += (i > 0 && i < length - 1) ? ', ' : ' and ';
							}
							msg += result[i].name;
						}
						UK.display({type: 'success', message: 'You have created ' + msg + '!'});
						UK.resetDrop();
					} else {
						UK.display({type: 'error', message: 'Sorry, no dice.'});
					}
					
				},
				error: function(xhr, status, e) {
					alert(e);
				}
			});
		};

		UK.addNewElement = function(json) {
			var result = [];
			var name = null;
			var id = null;
			for (var x in json.result) {
				id = json.result[x].id;
				name = json.result[x].name;
				if (id === "0") { return false; }
				result.push({'id': id, 'name': name});
				if (UK.$game.find('#'+id).length == 0) {
					UK.$game.find('#'+UK.defaults.list).append("<li id='"+id+"'><a href='/element/add'>"+name+"</a></li>");
				}
			}
			return result;
		};

		UK.resetDrop = function() {
			var dropEls = UK.$game.find('#'+UK.defaults.drop).html();
			UK.$game.find('#'+UK.defaults.drop).html('');
			UK.$game.find('#'+UK.defaults.list).append(dropEls);
		};

		UK.display  = function(options) {
			var type = options.type || false;
			var message = options.message || false;

			if (type && message) {
				UK.$result.html(message);
				if (type.toLowerCase() === 'error') {
					UK.$result.addClass('error').show();
				} else {
					UK.$result.removeClass('error').show();
				}
			}
		};
	});
})(jQuery);