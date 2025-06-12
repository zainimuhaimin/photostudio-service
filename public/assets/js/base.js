function getJadwalPemesananJasa(base_url, id) {
	console.log("id jasa base js " + id);
	$.ajax({
		url: base_url + "pemesanan/get-jadwal",
		type: "POST",
		data: {
			id_jasa: id,
		},
		dataType: "json",
		beforeSend: function (xhr) {
			console.log("Request data:", {
				url: base_url + "pemesanan/get-jadwal",
				method: "POST",
				data: { id_jasa: id },
			});
		},
		success: function (response) {
			console.log(response);
			let availableSlots = [];
			$.each(response.data.available_slots, function (index, booking) {
				availableSlots.push(index);
			});
			flatpickr("#jadwal", {
				enable: availableSlots,
				enableTime: true,
				dateFormat: "Y-m-d H:i",
				time_24hr: true,
				minTime: "09:00",
				maxTime: "18:00",
				minuteIncrement: 60,
				allowInput: false,
				onChange: function (selectedDates, dateStr, instance) {
					const timePattern = /\d{2}:\d{2}/;
					let date = selectedDates[0];
					// Get date value in YYYY-MM-DD format
					const dateValue = date.toISOString().split("T")[0];
					console.log("Selected date:", dateValue);
					const timeMatch = date.toTimeString().match(timePattern);
					const selectedTime = timeMatch ? timeMatch[0] : "";
					console.log("Selected time:", selectedTime);
					const minutes = selectedTime.split(":")[1];
					console.log("Minutes part:", minutes);

					if (minutes !== "00") {
						alert("Mohon Pilih Menit Dengan Format (00)");
						instance.clear(); // Clear the selected date/time
						return;
					}

					// Check if selected date/time is in booked slots
					if (response.data.booked_slots[dateValue]) {
						// Get booked slots for selected date
						$.each(
							response.data.booked_slots[dateValue],
							function (time, isBooked) {
								console.log(time, isBooked);
								// Check if selected time is in booked slots
								if (selectedTime === time) {
									alert(
										"Jasa Yang Kamu Pilih Sudah TerBooking Pada Jam " +
											time +
											", Silahkan Pilih Jam Lain"
									);
									instance.clear(); // Clear the selected date/time
									return;
								}
							}
						);
					}
				},
			});
		},
		error: function (xhr, status, error) {
			console.error("Error fetching schedule:", error);
		},
	});
}

function getJadwalPenyewaanAlat(base_url, id) {
	console.log("id alat base js " + id);
	$.ajax({
		url: base_url + "penyewaan/get-jadwal",
		type: "POST",
		data: {
			id_alat: id,
		},
		dataType: "json",
		beforeSend: function (xhr) {
			console.log("Request data:", {
				url: base_url + "pemesanan/get-jadwal",
				method: "POST",
				data: { id_alat: id },
			});
		},
		success: function (response) {
			console.log(response);
			let availableSlots = [];
			$.each(response.data.available_slots, function (index, booking) {
				availableSlots.push(index);
			});
			flatpickr("#jadwal", {
				enable: availableSlots,
				enableTime: true,
				dateFormat: "Y-m-d H:i",
				time_24hr: true,
				minTime: "09:00",
				maxTime: "18:00",
				minuteIncrement: 60,
				allowInput: false,
				onChange: function (selectedDates, dateStr, instance) {
					const timePattern = /\d{2}:\d{2}/;
					let date = selectedDates[0];
					// Get date value in YYYY-MM-DD format
					const dateValue = date.toISOString().split("T")[0];
					console.log("Selected date:", dateValue);
					const timeMatch = date.toTimeString().match(timePattern);
					const selectedTime = timeMatch ? timeMatch[0] : "";
					console.log("Selected time:", selectedTime);
					const minutes = selectedTime.split(":")[1];
					console.log("Minutes part:", minutes);

					if (minutes !== "00") {
						alert("Mohon Pilih Menit Dengan Format (00)");
						instance.clear(); // Clear the selected date/time
						return;
					}

					// Check if selected date/time is in booked slots
					if (response.data.booked_slots[dateValue]) {
						// Get booked slots for selected date
						$.each(
							response.data.booked_slots[dateValue],
							function (time, isBooked) {
								console.log(time, isBooked);
								// Check if selected time is in booked slots
								if (selectedTime === time) {
									alert(
										"Alat Yang Kamu Pilih Sudah TerBooking Pada Jam " +
											time +
											", Silahkan Pilih Jam Lain"
									);
									instance.clear(); // Clear the selected date/time
									return;
								}
							}
						);
					}
				},
			});
		},
		error: function (xhr, status, error) {
			console.error("Error fetching schedule:", error);
		},
	});
}
