/**
 * Elementor Ajax Select2 Script
 */

/* global sigmaAjaxObject */

export const sigmaAjaxSelect = (event, obj) => {
	const $ = jQuery;
	const sigmaSelect = '#elementor-control-default-' + obj.data._cid;

	setTimeout(function () {
		const IDSelect2 = $(sigmaSelect).select2({
			minimumInputLength: obj.data.minimum_input_length,
			maximumSelectionLength: obj.data.maximum_selection_length ?? -1,
			allowClear: true,

			ajax: {
				url: sigmaAjaxObject.ajaxUrl,
				dataType: 'json',
				delay: 250,
				method: 'POST',
				data(params) {
					return {
						action: 'sd_sigma_select2_object_search',
						post_type: obj.data.source_type,
						source_name: obj.data.source_name,
						search: params.term,
						page: params.page || 1,
						[sigmaAjaxObject.nonceId]:
							sigmaAjaxObject.sd_alsiha_nonce,
					};
				},
			},
			initSelection(element, callback) {
				if (!obj.multiple) {
					callback({ id: '', text: sigmaAjaxObject.searchText });
				} else {
					callback({ id: 9999, text: 'search' });
				}
				let ids = [];
				if (!Array.isArray(obj.currentID) && obj.currentID != '') {
					ids = [obj.currentID];
				} else if (Array.isArray(obj.currentID)) {
					ids = obj.currentID.filter(function (el) {
						return el != null;
					});
				}

				if (ids.length > 0) {
					const label = $(
						"label[for='elementor-control-default-" +
							obj.data._cid +
							"']"
					);
					label.after(
						'<span class="elementor-control-spinner">&nbsp;<i class="eicon-spinner eicon-animation-spin"></i>&nbsp;</span>'
					);
					$.ajax({
						method: 'POST',
						url:
							sigmaAjaxObject.ajaxUrl +
							'?action=sd_sigma_select2_get_title',
						data: {
							post_type: obj.data.source_type,
							source_name: obj.data.source_name,
							id: ids,
							[sigmaAjaxObject.nonceId]:
								sigmaAjaxObject.sd_alsiha_nonce,
						},
					}).done(function (response) {
						if (
							response.success &&
							typeof response.data.results !== 'undefined'
						) {
							let sigmaSelect2Options = '';
							ids.forEach(function (item, index) {
								if (
									typeof response.data.results[item] !==
									'undefined'
								) {
									const key = item;
									const value = response.data.results[item];
									sigmaSelect2Options += `<option selected="selected" value="${key}">${value}</option>`;
								}
							});

							element.append(sigmaSelect2Options);
						}
						label.siblings('.elementor-control-spinner').remove();
					});
				}
			},
		});

		//Select2 drag and drop : starts
		setTimeout(function () {
			IDSelect2.next()
				.children()
				.children()
				.children()
				.sortable({
					containment: 'parent',
					stop(event, ui) {
						ui.item
							.parent()
							.children('[title]')
							.each(function () {
								const title = $(this).attr('title');
								const original = $(
									'option:contains(' + title + ')',
									IDSelect2
								).first();
								original.detach();
								IDSelect2.append(original);
							});
						IDSelect2.change();
					},
				});
		}, 200);
	}, 100);
};
