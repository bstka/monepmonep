import { Grid, html, h } from "gridjs";
import "gridjs/dist/theme/mermaid.css";
import { deleteTargetReport, getPrepareTarget, postTargetReport, updateTargetReport } from "./request/report";

const has2Files = ['A', 'B', 'C', 'F', 'G'];

const STATE = {
    isEdit: false,
    currentPage: 'A',
    replacedHandler: false,
    selectedYear: new Date().getFullYear(),
    step: 5,
    subStep: 1
};

const mainTable = new Grid({
    columns: ["Program", "Kegiatan", "Keluaran", {
        name: "Target Penyelesaian",
        width: '600px',
        formatter: ({ targets: cell, id: programId }, row, col) => {
            return h('div', {
                children: [
                    h('div', {
                        className: 'w-full flex flex-row items-center justify-between uppercase text-xs font-semibold text-center',
                        children: cell.length > 0 && [
                            h('div', { className: 'w-full', children: 'Bulan' }),
                            h('div', { className: 'w-full', children: 'Tahun' }),
                            h('div', { className: 'w-full', children: 'Target' }),
                        ]
                    }),
                    ...cell.map((data, index) => {
                        const month = data.month < 10 ? ("B0" + data.month) : ("B" + data.month);
                        const year = yearParser(data.year);
                        const countReport = data.files.length;
                        const lastFile = data.files[countReport - 1];

                        return [
                            h('div', {
                                className: 'w-full flex flex-col items-center justify-center border-y hover:bg-base-100 p-2 gap-2',
                                children: h('div', {
                                    className: 'w-full flex flex-row items-center justify-between',
                                    children: [
                                        h('div', {
                                            className: 'w-full text-center',
                                            children: month
                                        }),
                                        h('div', {
                                            className: 'w-full text-center',
                                            children: year
                                        }),
                                        h('div', {
                                            className: 'w-full text-justify',
                                            children: data.name
                                        }),
                                    ]
                                })
                            }),
                            h('div', {
                                className: 'w-full flex flex-row items-center justify-end gap-2',
                                children: [
                                    h('p', {
                                        className: 'flex-1 uppercase text-xs font-semibold text-left text-blue-500',
                                        children: countReport > 0 ? `Laporan Ke-${countReport}` : ''
                                    }),
                                    countReport > 0 && h('button', {
                                        className: 'btn btn-xs btn-error',
                                        children: 'Hapus',
                                        onClick: () => deleteReport({ programId, targetId: data.id, file: lastFile })
                                    }),
                                    countReport > 0 && h('button', {
                                        className: 'btn btn-xs btn-warning',
                                        children: 'Lihat',
                                        onClick: () => {

                                        }
                                    }),
                                    countReport > 0 && h('button', {
                                        className: 'btn btn-xs btn-info',
                                        children: 'Ubah',
                                        onClick: () => {
                                            STATE.isEdit = true;
                                            updateReportModal(({ programId, targetId: data.id }));
                                        }
                                    }),
                                    h('button', {
                                        className: 'btn btn-xs btn-primary',
                                        children: 'Laporkan',
                                        onClick: () => {
                                            STATE.isEdit = false;
                                            updateReportModal({ programId, targetId: data.id });
                                        }
                                    }),
                                ]
                            })
                        ];
                    })
                ],
                className: 'w-full flex flex-col items-center justify-center h-full gap-4'
            });
        }
    },
        "Penilaian",
        {
            name: "Status",
            formatter: (cell, row, col) => {
                return h('div', {
                    className: '',
                    style: { color: cell.color },
                    children: cell.name
                });
            }
        }
    ],
    server: {
        url: `/api/programs/year/${STATE.selectedYear}/1/1`,
        handle: async (res) => {
            const raw = await res.json();
            return raw.data;
        },
        then: (data) => {
            return data.map((value, index) => {
                return [value.name, value.event, value.output, value, value.value, value.status];
            });
        }
    },
    className: {
        thead: 'text-center',
        table: 'w-full',
        tbody: 'w-full',
        tr: 'w-full',
        td: 'w-full',
        search: 'w-full flex flex-row items-center justify-center gap-4',
    },
    autoWidth: true,
    search: {
        enabled: true,
    },
    pagination: {
        enabled: true,
        limit: 5
    },
    language: {
        search: {
            placeholder: 'Masukan Kata Kunci Untuk Mencari 🔍'
        }
    }
});

const modalLabel = document.getElementById('toggle-modal');

function yearParser(year) {
    /*
        0 = Setiap tahun,
        1 = Setiap Ada Perubahan/Penetapan baru
        2 = Setiap Ada Kesepakatan/Penetapan baru
        3 = Setiap Ada Penetapan Baru
        4 = Setiap 5 Tahun / Tiap Perubahan atau Penetapan Baru
        5 = Setiap Ada Perubahan Baru
        6 = Setiap Ada Penetapan Baru
        7 = Setiap Ada Pembangunan Baru
        8 = Setiap 10 tahun
        9 = Setiap Ada Sensus Baru
    */

    const readableYear = [
        'Setiap tahun',
        'Setiap Ada Perubahan/Penetapan baru',
        'Setiap Ada Kesepakatan/Penetapan baru',
        'Setiap Ada Penetapan Baru',
        'Setiap 5 Tahun / Tiap Perubahan atau Penetapan Baru',
        'Setiap Ada Perubahan Baru',
        'Setiap Ada Penetapan Baru',
        'Setiap Ada Pembangunan Baru',
        'Setiap 10 tahun',
        'Setiap Ada Sensus Baru'
    ];

    if (readableYear.findIndex((value, index) => index === year) > -1) {
        return readableYear[year];
    } else {
        return year;
    }
}

async function deleteReport({ programId, targetId, file }) {
    if (confirm('Apakah anda yakin untuk menghapus laporan ini?')) {
        try {
            const { error } = await deleteTargetReport({ programId, targetId, fileId: file.id }, {
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            });

            if (!error) {
                mainTable.forceRender();
            }
        } catch (error) {
            console.log(error);
        }
    }
}

async function updateReportModal({ programId, targetId }) {
    const { data: { data }, error } = await getPrepareTarget({ programId, targetId });

    const reportForm = document.getElementById('reportForm');
    const reportTitle = document.getElementById('reportTitle');
    const reportOutput = document.getElementById('reportOutput');
    const reportInstanceResponsible = document.getElementById('reportInstanceResponsible');
    const reportRelatedInstances = document.getElementById('reportRelatedInstances');
    const reportTarget = document.getElementById('reportTarget');
    const reportMonth = document.getElementById('reportMonth');
    const reportYear = document.getElementById('reportYear');
    const reportQuantitiveTarget = document.getElementById('reportQuantitiveTarget');
    const reportUnit = document.getElementById('reportUnit');
    const reportId = document.getElementById('reportIdx');
    const programIdx = document.getElementById('programIdx');
    const reportDesc = document.getElementById('reportDesc');
    const provinceSelector = document.getElementById('provinceChecks');
    const compilation_target_count = document.querySelector('input[name="compilation_target_count"]');
    const integration_target_count = document.querySelector('input[name="integration_target_count"]');
    const syncronization_target_count = document.querySelector('input[name="syncronization_target_count"]');
    const publication_target_count = document.querySelector('input[name="publication_target_count"]');
    const areaOfRealization = document.querySelector('input[value="partial"]');
    const integrationFile = document.getElementById('integrationFile');
    const compilationFile = document.getElementById('compilationFile');
    const provinceCheckBoxes = document.querySelectorAll('input[class="checkbox checkbox-sm checkbox-primary chk-province"]');
    const integrationFileContainer = document.getElementById('integrationFileContainer');
    const compilationFileContainer = document.getElementById('compilationFileContainer');
    const targetCountContainer = document.getElementById('targetCountContainer');

    const month = data.target.month < 10 ? ("B0" + data.target.month) : ("B" + data.target.month);

    [integrationFile, compilationFile].forEach((element) => { element.innerHTML = ''; });

    reportForm.reset();
    reportDesc.textContent = '';

    provinceSelector.classList.remove('grid');
    provinceSelector.classList.add('hidden');

    if (!error) {
        reportTitle.textContent = data.program.name;
        reportOutput.textContent = data.program.output;
        reportInstanceResponsible.textContent = data.program.instance.name;
        reportTarget.textContent = data.target.name;
        reportMonth.textContent = month;
        reportYear.textContent = yearParser(data.target.year);
        reportQuantitiveTarget.textContent = data.program.quantitive;
        reportUnit.textContent = data.program.unit.name;
        reportId.setAttribute('value', data.target.id);
        programIdx.setAttribute('value', data.program.id);
        areaOfRealization.removeAttribute('checked');

        provinceCheckBoxes.forEach((element) => element.removeAttribute('checked'));

        if (has2Files.indexOf(STATE.currentPage) > -1) {
            compilationFileContainer.classList.remove('hidden');
            compilationFileContainer.classList.add('flex');
        } else {
            targetCountContainer.classList.remove('hidden');
            targetCountContainer.classList.add('flex');

            [integrationFileContainer, compilationFileContainer].forEach((element) => {
                element.classList.remove('hidden');
                element.classList.add('flex');
            });
        }


        if (STATE.isEdit) {
            const lastIndex = data.target.files.length - 1;
            const file = data.target.files[lastIndex];

            function boundPostReport(events) {
                postReport(events, file.id);
            }

            if (!STATE.replacedHandler) {
                console.log("deleted");
                reportForm.removeEventListener('submit', postReport);
                reportForm.addEventListener('submit', boundPostReport);
                STATE.replacedHandler = true;
            }

            [[integrationFile, file.integration_doc], [compilationFile, file.compilation_doc]].forEach((element) => {
                if (element[1] !== null) {
                    const badgeElement = document.createElement('button');
                    badgeElement.textContent = element[1];
                    badgeElement.classList.add('btn', 'btn-xs', 'font-semibold', 'w-fit');
                    badgeElement.setAttribute('type', 'button');
                    badgeElement.addEventListener('click', () => console.log("click"));

                    element[0].appendChild(badgeElement);
                }
            });

            compilation_target_count.setAttribute('value', file.compilation_target_count);
            integration_target_count.setAttribute('value', file.integration_target_count);
            syncronization_target_count.setAttribute('value', file.syncronization_target_count);
            publication_target_count.setAttribute('value', file.publication_target_count);
            reportDesc.textContent = file.description;

            const provinceIds = file.provinces.map((data) => data.id);
            const checkboxArray = Array.from(provinceCheckBoxes).filter((element) => {
                return provinceIds.indexOf(Number(element.value)) > -1 ? true : false;
            });

            checkboxArray.forEach((element) => {
                element.setAttribute('checked', 'checked');
            });

            if (provinceIds.length > 0) {
                areaOfRealization.setAttribute('checked', 'checked');
            }

            provinceSelector.classList.remove('hidden');
            provinceSelector.classList.add('grid');
        } else {
            reportForm.addEventListener('submit', postReport);
            STATE.isEdit = false;
        }

        modalLabel.click();
    } else {
        console.log(error);
    }
}

// ! Report Form Event Handler!
async function postReport(events, fileId = 0) {
    events.preventDefault();
    const form = new FormData(events.target);
    const provinceCodes = [];
    const prePostData = {};

    for (const key of form.keys()) {
        if (key.match(/^province_\d{2}$/g)) {
            provinceCodes.push(form.get(key));
        } else {
            prePostData[key] = form.get(key);
        }
    }

    const parseToFormData = new FormData();

    for (const key in prePostData) {
        parseToFormData.append(key, prePostData[key]);
    }

    // Append CSRF Token
    parseToFormData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    // Append Pronvinces Array
    provinceCodes.forEach(v => {
        parseToFormData.append('provinces[]', v);
    });

    try {
        if (!STATE.isEdit) {
            const { data, error } = await postTargetReport(parseToFormData, prePostData.programId, prePostData.reportId);
            if (!error) {
                mainTable.forceRender();
                modalLabel.click();
            }
        } else {
            const { data, error } = await updateTargetReport({ programId: prePostData.programId, targetId: prePostData.reportId, fileId: fileId }, parseToFormData);
            if (!error) {
                mainTable.forceRender();
                modalLabel.click();
            }
        }
    } catch (error) {
        console.log(error);
    }
}


mainTable.render(document.getElementById("mainTable"));

// ! Creating timeline selector!
const years = [
    2021, 2022, 2023, 2024, 2025, 2026
];

mainTable.on('ready', () => {
    const selectElements = document.createElement('select');
    selectElements.classList.add('select', 'w-full', 'outline-none', 'max-w-[150px]', 'bg-primary', 'text-white', 'text-xl', 'text-center');
    selectElements.setAttribute('id', 'selectYear');
    selectElements.addEventListener('change', events => {
        const year = events.target.value;
        STATE.selectedYear = year;

        const { url, ...rest } = mainTable.config.server;

        mainTable.updateConfig({
            server: {
                url: `/api/programs/year/${year}/${STATE.step}/${STATE.subStep}`,
                ...rest
            }
        });

        mainTable.forceRender();
    });

    const searchContainer = document.getElementsByClassName('gridjs-search')[0];

    const selectYearElement = document.getElementById('selectYear');

    if (selectYearElement !== null) {
        searchContainer.removeChild(selectYearElement);
        searchContainer.appendChild(selectElements);
    } else {
        searchContainer.appendChild(selectElements);
    }

    for (const year of years) {
        const optionsElements = document.createElement('option');
        optionsElements.value = year;
        optionsElements.textContent = year;

        if (year == STATE.selectedYear) optionsElements.setAttribute('selected', 'selected');

        selectElements.appendChild(optionsElements);
    }
});

// ! Sidebar Button Event Listener!
const sidebarButton = document.querySelectorAll('button[data-xss]');

async function sideBarButtonHandler(buttonElement) {
    const step = buttonElement.dataset.xs;
    const subStep = buttonElement.dataset.xss;
    const selectedPage = buttonElement.dataset.page;

    STATE.currentPage = selectedPage;
    STATE.step = step;
    STATE.subStep = subStep;

    const { url, ...rest } = mainTable.config.server;

    mainTable.updateConfig({
        server: {
            url: `/api/programs/year/${STATE.selectedYear}/${step}/${subStep}`,
            ...rest
        }
    });

    mainTable.forceRender();
}

sidebarButton.forEach((element) => {
    element.addEventListener('click', events => sideBarButtonHandler(element));
});

// ! Partial Province Selector!
const provinceSelectorRadio = document.querySelectorAll('input.radio.radio-partial');
provinceSelectorRadio.forEach((element) => {
    const provinceSelector = document.getElementById('provinceChecks');

    if (element.value === 'partial') {
        element.addEventListener('click', (events) => {

            if (element.checked) {
                provinceSelector.classList.remove('hidden');
                provinceSelector.classList.add('grid');
            } else {
                provinceSelector.classList.remove('grid');
                provinceSelector.classList.add('hidden');
            }
        });
    } else {
        element.addEventListener('click', (events) => {

            if (element.checked) {
                provinceSelector.classList.remove('grid');
                provinceSelector.classList.add('hidden');
            } else {
                provinceSelector.classList.remove('hidden');
                provinceSelector.classList.add('grid');
            }
        });
    }
});

const notifDeleteButtons = document.querySelectorAll('button.notification-read-button');
notifDeleteButtons.forEach(element => {
    element.addEventListener('click', events => {
        const notifId = element.dataset.nfid;
        
    });
});
