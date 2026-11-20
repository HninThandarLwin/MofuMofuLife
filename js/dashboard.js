document.addEventListener("DOMContentLoaded", () => {
  // ==========================
  // Today's Date
  // ==========================
  const todayLabel = document.getElementById("todayLabel");

  if (todayLabel) {
    const today = new Date();

    const week = ["日", "月", "火", "水", "木", "金", "土"];

    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, "0");
    const day = String(today.getDate()).padStart(2, "0");

    todayLabel.textContent = `${year}/${month}/${day} (${week[today.getDay()]})`;
  }

  // ==========================
  // Dashboard Sections
  // ==========================

  updateSection("collectionList", "emptyCollection", "collectionCount");

  updateSection("scheduleList", "emptySchedule", "scheduleCount");

  updateSection("taskList", "emptyTask", "taskCount");

  updateSection("activityList", "emptyActivity", null);

  // ==========================
  // Edit Task Modal
  // ==========================

  const editButtons = document.querySelectorAll(".editBtn");

  editButtons.forEach((button) => {
    button.addEventListener("click", function () {
      document.getElementById("editId").value = this.dataset.id;

      document.getElementById("editTitle").value = this.dataset.title;

      document.getElementById("editType").value = this.dataset.type;

      document.getElementById("editDescription").value =
        this.dataset.description;

      document.getElementById("editStart").value = this.dataset.start
        .substring(0, 16)
        .replace(" ", "T");

      document.getElementById("editEnd").value = this.dataset.end
        .substring(0, 16)
        .replace(" ", "T");

      const modal = new bootstrap.Modal(document.getElementById("editModal"));
toggleTimeFields();
      modal.show();
    });
  });
});

// ==================================
// Count Items + Empty Message
// ==================================

function updateSection(listId, emptyId, countId) {
  const list = document.getElementById(listId);

  const empty = document.getElementById(emptyId);

  if (!list) return;
  const total = list.children.length;

  if (empty) {
    if (total === 0) {
      empty.style.display = "block";
    } else {
      empty.style.display = "none";
    }
  }

  if (countId) {
    const counter = document.getElementById(countId);

    if (counter) {
      counter.textContent = total;
    }
  }
}

// ===========================
// Delete Task
// ===========================
function deleteTask(taskId) {
  if (confirm("削除しますか？")) {
    window.location.href = "delete.php?id=" + taskId;
  }
}

//  function update toggleTimeFields
function toggleTimeFields() {

  const type = document.getElementById("editType").value;
  const timeFields = document.getElementById("timeFields");
  const startTime = document.getElementById("editStart");
  const endTime = document.getElementById("editEnd");
  if (type === "todo") {
    timeFields.style.display = "none";
  } else {
    timeFields.style.display = "block";
    startTime.required = true;
    endTime.required = true;
  }

}
