import VueCookie from "vue-cookie";
const state = () => ({
  questions: [
    {
      question:
        "What’s your first and last name?",
      generalQuestion: true,
      fields: [
        {
          label: "First Name",
          placeholder: "First Name",
          name: "firstName",
          type: "text",
          component: "TextField"
        },
        {
          label: "Last Name",
          placeholder: "Last Name",
          name: "lastName",
          type: "text",
          component: "TextField"
        }
      ]
    },
    {
      question: "What's the best phone number to reach you at?",
      generalQuestion: true,
      fields: [
        {
          label: "Phone Number",
          placeholder: "(111) 111-1111",
          name: "phoneNumber",
          type: "tel",
          component: "TextField"
        }
      ]
    },
    {
      question: "What’s the best email to reach you at?",
      generalQuestion: true,
      fields: [
        {
          label: "Email",
          placeholder: "Enter Email (user@gmail.com)",
          name: "email",
          type: "email",
          component: "TextField"
        }
      ]
    },
    {
      question:
        "What's your address? This is where your medicine will be delivered if prescribed",
      generalQuestion: true,
      type: "address",
      fields: [
        {
          label: "Address",
          placeholder: "Address",
          name: "address",
          type: "address",
          component: "Address"
        }
      ]
    },
    {
      question: "Are you allergic to any medications?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouAllergicToAnyMedications",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  lable: "",
                  placeholder: "",
                  name: "whyYouAllergicToMedications",
                  component: "AutoComplete"
                }
              ]
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    },
    {
      question: "Are you currently taking any medications or vitamins?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouTakingAnyMedications",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  lable: "",
                  placeholder: "",
                  name: "whichMedicationsOrVitamins",
                  component: "AutoComplete"
                }
              ]
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    },
    {
      question:
        "To make sure you get the proper dosage what's your Weight?",
      generalQuestion: true,
      fields: [
        {
          label: "Weigth",
          placeholder: "Enter Weight",
          name: "weight",
          type: "number",
          component: "Weight"
        }
      ]
    },
    {
      question:
        "To make sure you get the proper dosage what's your Height?",
      generalQuestion: true,
      fields: [
       
        {
          label: "Height",
          placeholder: "Enter height ( Less than 9 )",
          type: "text",
          component: "Height"
        }
      ]
    },
    {
      question:
        "What's your Date of Birth? We can only help people over 18 years of age",
      generalQuestion: true,
      fields: [
        {
          label: "Date of Birth",
          placeholder: "mm/dd/yy",
          name: "dateOfBirth",
          type: "date",
          component: "DateFields"
        }
      ]
    },
    // {
    //   question: "What's your Gender?",
    //   noSubmit: false,
    //   fields: [
    //     {
    //       label: "Gender",
    //       placeholder: "",
    //       name: "gender",
    //       type: "check",
    //       component: "Radio",
    //       options: [
    //         {
    //           text: 'Male',
    //           value: 'male'
    //         },
    //         {
    //           text: 'Female',
    //           value: 'female'
    //         }
    //       ]
    //     }
    //   ]
    // },

    {
      question:
        "Over the past two weeks, how often have you had little interest in doing the things you used to enjoy?",
      noSubmit: false,
      fields: [
        {
          label: "littleInterestInDoingTheThings",
          placeholder: "",
          name: "littleInterestInDoingTheThings",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you felt down, depressed, or hopeless?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouFeltDown",
          placeholder: "",
          name: "oftenHaveYouFeltDown",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you had trouble falling or staying asleep, or sleeping too much?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouTroubleFalling",
          placeholder: "",
          name: "oftenHaveYouTroubleFalling",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you felt tired, or had little energy?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouFeltTired",
          placeholder: "",
          name: "oftenHaveYouFeltTired",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you had a poor appetite, or have over-eaten?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouHadAPoorAppetite",
          placeholder: "",
          name: "oftenHaveYouHadAPoorAppetite",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you felt bad about yourself, that you are a failure, or that you have let your family down?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouFeltBad",
          placeholder: "",
          name: "oftenHaveYouFeltBad",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you had trouble concentrating on things such as reading, or watching television?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouTroubleConcentrating",
          placeholder: "",
          name: "oftenHaveYouTroubleConcentrating",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you been bothered by the following problem?:Moving or speaking so slowly that other people could have noticed. Or the opposite  - Being so fidgety or restless that you have been moving around a lot more than usual",
      noSubmit: false,
      fields: [
        {
          label: "alotMoreThanUsual",
          placeholder: "",
          name: "alotMoreThanUsual",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you had thoughts that you would be better off dead, or of hurting yourself",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouFeltOffDead",
          placeholder: "",
          name: "oftenHaveYouFeltOffDead",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },

    {
      question:
        "Over the past two weeks, how often have you been bothered by feeling nervous, anxious, or on edge?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouFeltNervous",
          placeholder: "",
          name: "oftenHaveYouFeltNervous",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you been bothered by not being able to stop or control worrying?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouFeltWorrying",
          placeholder: "",
          name: "oftenHaveYouFeltWorrying",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you been bothered by worrying too much about different things?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouFeltBothered",
          placeholder: "",
          name: "oftenHaveYouFeltBothered",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you been bothered by trouble relaxing?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouFeltRelaxing",
          placeholder: "",
          name: "oftenHaveYouFeltRelaxing",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you been bothered by being so restless that it is hard to sit still?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouFeltSitStill",
          placeholder: "",
          name: "oftenHaveYouFeltSitStill",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you been bothered by becoming easily annoyed or irritable?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouFeltIrritable",
          placeholder: "",
          name: "oftenHaveYouFeltIrritable",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you been bothered by feeling afraid as if something awful might happen?",
      noSubmit: false,
      fields: [
        {
          label: "oftenHaveYouFeltHappen",
          placeholder: "",
          name: "oftenHaveYouFeltDown",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "nearly every day",
              value: "nearly every day"
            },
            {
              text: "more than half the days",
              value: "more than half the days"
            },
            {
              text: "several days",
              value: "several days"
            },
            {
              text: "not at all",
              value: "not at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Since you started the medication, have you experienced any side effects?",
      noSubmit: false,
      fields: [
        {
          label: "experiencedAnySideEffects",
          placeholder: "",
          name: "experiencedAnySideEffects",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Worsening of anxiety/depression",
              value: "Worsening of anxiety/depression"
            },
            {
              text: "GI upset (nausea/vomiting/diarrhea)",
              value: "GI upset (nausea/vomiting/diarrhea)"
            },
            {
              text: "Weight gain/weight loss",
              value: "Weight gain/weight loss"
            },
            {
              text: "Decreased libido/sexual dysfunction",
              value: "Decreased libido/sexual dysfunction"
            },
            {
              text: "Headaches",
              value: "Headaches"
            },
            {
              text: "Sedation/fatigue",
              value: "Sedation/fatigue"
            },
            {
              text: "Dry mouth",
              value: "Dry mouth"
            }
          ]
        }
      ]
    },
    {
      question: "If yes, how bothersome were these side effects?",
      noSubmit: false,
      fields: [
        {
          label: "bothersome ",
          placeholder: "",
          name: "bothersome",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "No problem",
              value: "No problem"
            },
            {
              text: "Minor problem",
              value: "Minor problem"
            },
            {
              text: "Moderate problem",
              value: "Moderate problem"
            },
            {
              text: "Serious problem",
              value: "Serious problem"
            }
          ]
        }
      ]
    }
  ],
  result: {
    form: "ed"
  },
  qas: {}
});

const mutations = {
  CHECK_ED_AND_SET: function(state) {
    if (VueCookie.get("result")) {
      state.result = JSON.parse(VueCookie.get("result"));
    }
    if (VueCookie.get("qas")) {
      state.qas = JSON.parse(VueCookie.get("qas"));
    }
  },
  saveED: function(state) {
    VueCookie.set("result", JSON.stringify(state.result), {
      expires: "1h"
    });
    VueCookie.set("qas", JSON.stringify(state.qas), {
      expires: "1h"
    });
  },
  SET_QAS: function(state) {
    let qas = state.questions.filter(q => !q.generalQuestion);
    let q = qas.map(q => {
      return q.question;
    });
    let a = qas.map(q => {
      if (state.result[q.fields[0].name] !== undefined) {
        if (q.fields[0].component == "Checkbox") {
          if (state.result[q.fields[0].name][0] == null) {
            return "none of these apply";
          }
        }
        if(  (q.fields[0].name === 'areYouAllergicToAnyMedications' && state.result[q.fields[0].name] !== 'No') || (q.fields[0].name === 'areYouTakingAnyMedications' && state.result[q.fields[0].name] !== 'No')){
          console.log('a', q.fields[0].name)
          return state.result[q.fields[0].options[0].fields[0].name]
        }
        else{
          console.log('b', q.fields[0].name)

          return state.result[q.fields[0].name];

        }
        // return state.result[q.fields[0].name];
      }
    });
    state.qas = {
      q,
      a
    };
  }
};

const actions = {};

const getters = {};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
