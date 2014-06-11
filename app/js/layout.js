(function($){
	var initLayout = function() {
		var hash = window.location.hash.replace('#', '');
		var currentTab = $('ul.navigationTabs a')
							.bind('click', showTab)
							.filter('a[rel=' + hash + ']');
		if (currentTab.size() == 0) {
			currentTab = $('ul.navigationTabs a:first');
		}
		showTab.apply(currentTab.get(0));
		$('#date').DatePicker({
			flat: true,
			date: '2014-07-31',
			current: '2014-07-31',
			calendars: 1,
			starts: 1,
			view: 'years'
		});
		var now = new Date();
		now.addDays(-10);
		var now2 = new Date();
		now2.addDays(-5);
		now2.setHours(0,0,0,0);
		$('#date2').DatePicker({
			flat: true,
			date: ['2014-07-31', '2008-07-28'],
			current: '2014-07-31',
			format: 'Y-m-d',
			calendars: 1,
			mode: 'multiple',
			onRender: function(date) {
				return {
					disabled: (date.valueOf() < now.valueOf()),
					className: date.valueOf() == now2.valueOf() ? 'datepickerSpecial' : false
				}
			},
			onChange: function(formated, dates) {
			},
			starts: 0
		});
		$('#clearSelection').bind('click', function(){
			$('#date3').DatePickerClear();
			return false;
		});
		$('#date3').DatePicker({
			flat: true,
			date: ['2009-12-28','2010-01-23'],
			current: '2010-01-01',
			calendars: 3,
			mode: 'range',
			starts: 1
		});
		$('#inputDatej1').DatePicker({
			format:'Y-m-d',
			date: $('#inputDatej1').val(),
			current: new Date(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#inputDatej1').DatePickerSetDate($('#inputDatej1').val(), false);
			},
			onChange: function(formated, dates){
				$('#inputDatej1').val(formated);
				if ($('#closeOnSelect input').attr('checked')) {
					$('#inputDatej1').DatePickerHide();
				}
			}
		});
		$('#inputDatej2').DatePicker({
			format:'Y-m-d',
			date: $('#inputDatej2').val(),
			current: new Date(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#inputDatej2').DatePickerSetDate($('#inputDatej2').val(), false);
			},
			onChange: function(formated, dates){
				$('#inputDatej2').val(formated);
				if ($('#closeOnSelect input').attr('checked')) {
					$('#inputDatej2').DatePickerHide();
				}
			}
		});
		
		$('#inputDatej3').DatePicker({
			format:'Y-m-d',
			date: $('#inputDatej3').val(),
			current: new Date(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#inputDatej3').DatePickerSetDate($('#inputDatej3').val(), false);
			},
			onChange: function(formated, dates){
				$('#inputDatej3').val(formated);
				if ($('#closeOnSelect input').attr('checked')) {
					$('#inputDatej3').DatePickerHide();
				}
			}
		});
		
		$('#inputDatej4').DatePicker({
			format:'Y-m-d',
			date: $('#inputDatej4').val(),
			current: new Date(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#inputDatej4').DatePickerSetDate($('#inputDatej4').val(), false);
			},
			onChange: function(formated, dates){
				$('#inputDatej4').val(formated);
				if ($('#closeOnSelect input').attr('checked')) {
					$('#inputDatej4').DatePickerHide();
				}
			}
		});
		
		$('#inputDatej5').DatePicker({
			format:'Y-m-d',
			date: $('#inputDatej5').val(),
			current: new Date(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#inputDatej5').DatePickerSetDate($('#inputDatej5').val(), false);
			},
			onChange: function(formated, dates){
				$('#inputDatej5').val(formated);
				if ($('#closeOnSelect input').attr('checked')) {
					$('#inputDatej5').DatePickerHide();
				}
			}
		});
		
		
		$('#inputDatej6').DatePicker({
			format:'Y-m-d',
			date: $('#inputDatej6').val(),
			current: new Date(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#inputDatej6').DatePickerSetDate($('#inputDatej6').val(), false);
			},
			onChange: function(formated, dates){
				$('#inputDatej6').val(formated);
				if ($('#closeOnSelect input').attr('checked')) {
					$('#inputDatej6').DatePickerHide();
				}
			}
		});
		
		$('#inputDatej7').DatePicker({
			format:'Y-m-d',
			date: $('#inputDatej7').val(),
			current: new Date(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#inputDatej7').DatePickerSetDate($('#inputDatej7').val(), false);
			},
			onChange: function(formated, dates){
				$('#inputDatej7').val(formated);
				if ($('#closeOnSelect input').attr('checked')) {
					$('#inputDatej7').DatePickerHide();
				}
			}
		});
		
		$('#inputDatej8').DatePicker({
			format:'Y-m-d',
			date: $('#inputDatej8').val(),
			current: new Date(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#inputDatej8').DatePickerSetDate($('#inputDatej8').val(), false);
			},
			onChange: function(formated, dates){
				$('#inputDatej8').val(formated);
				if ($('#closeOnSelect input').attr('checked')) {
					$('#inputDatej8').DatePickerHide();
				}
			}
		});
		
		$('#inputDatej9').DatePicker({
			format:'Y-m-d',
			date: $('#inputDatej9').val(),
			current: new Date(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#inputDatej9').DatePickerSetDate($('#inputDatej9').val(), false);
			},
			onChange: function(formated, dates){
				$('#inputDatej9').val(formated);
				if ($('#closeOnSelect input').attr('checked')) {
					$('#inputDatej9').DatePickerHide();
				}
			}
		});
		
		$('#inputDatej10').DatePicker({
			format:'Y-m-d',
			date: $('#inputDatej10').val(),
			current: new Date(),
			starts: 1,
			position: 'right',
			onBeforeShow: function(){
				$('#inputDatej10').DatePickerSetDate($('#inputDatej10').val(), false);
			},
			onChange: function(formated, dates){
				$('#inputDatej10').val(formated);
				if ($('#closeOnSelect input').attr('checked')) {
					$('#inputDatej9').DatePickerHide();
				}
			}
		});
		
		
		var now3 = new Date();
		now3.addDays(-4);
		var now4 = new Date()
		$('#widgetCalendar').DatePicker({
			flat: true,
			format: 'd B, Y',
			date: [new Date(now3), new Date(now4)],
			calendars: 3,
			mode: 'range',
			starts: 1,
			onChange: function(formated) {
				$('#widgetField span').get(0).innerHTML = formated.join(' &divide; ');
			}
		});
		var state = false;
		$('#widgetField>a').bind('click', function(){
			$('#widgetCalendar').stop().animate({height: state ? 0 : $('#widgetCalendar div.datepicker').get(0).offsetHeight}, 500);
			state = !state;
			return false;
		});
		$('#widgetCalendar div.datepicker').css('position', 'absolute');
	};
	
	var showTab = function(e) {
		var tabIndex = $('ul.navigationTabs a')
							.removeClass('active')
							.index(this);
		$(this)
			.addClass('active')
			.blur();
		$('div.tab')
			.hide()
				.eq(tabIndex)
				.show();
	};
	
	EYE.register(initLayout, 'init');
})(jQuery)