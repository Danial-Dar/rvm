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
        "Have you seen a psychiatrist or other professional for depression?",
      noSubmit: false,
      fields: [
        {
          label: "seenPsychiatrist",
          placeholder: "",
          name: "seenPsychiatrist",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes, within the last 6 months",
              value: "Yes, within the last 6 months"
            },
            {
              text: "Yes, in the past",
              value: "Yes, in the past"
            },
            {
              text: "Never been seen for depression",
              value: "Never been seen for depression"
            }
          ]
        }
      ]
    },
    {
      question:
        "If yes, please explain your encounter with the doctor or psychiatrist?",
      fields: [
        {
          label: "",
          placeholder: "explain your encounter with the doctor or psychiatrist",
          name: "encounterPsychiatrist",
          component: "TextField"
        }
      ]
    },
    {
      question: "Do you currently have a primary care provider (PCP)?",
      noSubmit: false,
      fields: [
        {
          label: "primaryCareProvider",
          placeholder: "",
          name: "primaryCareProvider",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "Yes"
            },
            {
              text: "No",
              value: "No"
            }
          ]
        }
      ]
    },

    {
      question: "Have you been diagnosed with any of the following?",
      
      fields: [
        {
          label: "diagnosedWithFollowing",
          placeholder: "",
          name: "diagnosedWithFollowing",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Anxiety",
              value: "Anxiety"
            },
            {
              text: "Depression",
              value: "Depression"
            },
            {
              text: "Bipolar disorder",
              value: "Bipolar disorder"
            },
            {
              text: "Schizophrenia",
              value: "Schizophrenia"
            },
            {
              text: "Neuropathy",
              value: "Neuropathy"
            },
            {
              text: "Migraines",
              value: "Migraines"
            },
            {
              text: "Fibromyalgia",
              value: "Fibromyalgia"
            },
            {
              text: "Insomnia",
              value: "Insomnia"
            },
            {
              text: "Obsessive compulsive disorder",
              value: "Obsessive compulsive disorder"
            },
            {
              text: "Others",
              value: "Others"
            },
            {
              text: "None apply",
              value: "None apply",
              // next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "Have any of your blood relatives (ie, children, siblings, parents, grandparents, aunts, uncles) been diagnosed with manic-depressive illness or bipolar disorder?",
        noSubmit: false,
        fields: [
        {
          label: "bloodRelativesDiagnosed ",
          placeholder: "",
          name: "bloodRelativesDiagnosed",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "Yes"
            },
            {
              text: "No",
              value: "No"
            }
          ]
        }
      ]
    },
    {
      question:
        "Have you ever had or are your having suicidal or homicidal thoughts? Have you ever or are your currently thinking of harming yourself or others?",
        noSubmit: false,
    
        fields: [
        {
          label: "suicidalThoughts ",
          placeholder: "",
          name: "suicidalThoughts",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "Yes"
            },
            {
              text: "No",
              value: "No"
            }
          ]
        }
      ]
    },
    {
      question:
        "Have you ever suffered from seizures or have you been treated with anti-seizure medication/s even as a child? Have you ever suffered a head injury like in a vehicle accident or a fall or other such event where you lost consciousness even for a few seconds?",
        noSubmit: false,
     
        fields: [
        {
          label: "sufferedFromSeizures ",
          placeholder: "",
          name: "sufferedFromSeizures",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "Yes"
            },
            {
              text: "No",
              value: "No"
            }
          ]
        }
      ]
    },
    {
      question: "Are you currently taking medication for depression?",
      noSubmit: false,
      fields: [
        {
          label: "medicationForDepression",
          placeholder: "",
          name: "medicationForDepression",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes, I need a different medication",
              value: "Yes, I need a different medication"
            },
            {
              text: "Yes, I want to continue taking some antidepressant",
              value: "Yes, I want to continue taking some antidepressant"
            },
            {
              text: "None",
              value: "None"
            }
          ]
        }
      ]
    },
    {
      question:
        "Please select which of these substance you have used in the past or currently use.",

      fields: [
        {
          label: "substanceUsedInPast",
          placeholder: "",
          name: "substanceUsedInPast",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Alcohol",
              value: "Alcohol"
            },
            {
              text: "Amphetamines",
              value: "Amphetamines"
            },
            {
              text: "Barbiturates/Owners",
              value: "Barbiturates/Owners"
            },
            {
              text: "Caffeine",
              value: "Caffeine"
            },
            {
              text: "Cocaine",
              value: "Cocaine"
            },
            {
              text: "Crack cocaine",
              value: "Crack cocaine"
            },
            {
              text: "Hallucinogens (e.g. LSD)",
              value: "Hallucinogens (e.g. LSD)"
            },
            {
              text: "Inhalants (e.g. glue, gas)",
              value: "Inhalants (e.g. glue, gas)"
            },
            {
              text: "Marijuana or hashish",
              value: "Marijuana or hashish"
            },
            {
              text: "Nicotine/cigarettes",
              value: "Nicotine/cigarettes"
            },
            {
              text: "PCP",
              value: "PCP"
            },
            {
              text: "Others",
              value: "Others"
            },
            {
              text: "None",
              value: "None",
              // next: true 
            }
          ]
        }
      ]
    },
    {
      question: "If other(s), please specify.",
      fields: [
        {
          label: "",
          placeholder: " please specify",
          name: "othersPleaseSpecify",
          component: "TextField"
        }
      ]
    },
    {
      question:
        "If nicotine, how much do you smoke? How long have you been smoking?",
      fields: [
        {
          label: "",
          placeholder: "how much do you smoke?",
          name: "ifNicotine",
          component: "TextField"
        }
      ]
    },
    {
      question:
        "If prescription or recreational drug, please list the names of those drugs.",
      fields: [
        {
          label: "",
          placeholder: "please list the names of those drugs.",
          name: " namesOfThoseDrugs",
          component: "TextField"
        }
      ]
    },
    {
      question: "If alcohol, how much do you drink per month?",
      fields: [
        {
          label: "",
          placeholder: "drink per month",
          name: "drinkPerMonth",
          component: "TextField"
        }
      ]
    },
    {
      question: "When did your symptoms start?",
      noSubmit: false,
      fields: [
        {
          label: "symptomsStart",
          placeholder: "",
          name: "symptomsStart",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Less than 1 month",
              value: "Less than 1 month"
            },
            {
              text: "1-6 months",
              value: "1-6 months"
            },
            {
              text: "Over 6 months",
              value: "Over 6 months"
            }
          ]
        }
      ]
    },
    {
      question:
        "Over the past two weeks, how often have you had little interest in doing the things you used to enjoy?",
      noSubmit: false,
      fields: [
        {
          label: "interestInDoingThings",
          placeholder: "",
          name: "interestInDoingThings",
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
          label: " feltDown",
          placeholder: "",
          name: "feltDown",
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
          label: "stayingAsleep",
          placeholder: "",
          name: "stayingAsleep",
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
          label: "feltTired",
          placeholder: "",
          name: "feltTired",
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
        "Over the past two weeks, how often have you had a poor appetite, or have over-eaten? ",
      noSubmit: false,
      fields: [
        {
          label: "poorAppetite",
          placeholder: "",
          name: "poorAppetite",
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
          label: "failure",
          placeholder: "",
          name: "failure",
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
          label: "concentrating",
          placeholder: "",
          name: "concentrating",
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
        "Over the past two weeks, how often have you been bothered by the following problem?: Moving or speaking so slowly that other people could have noticed. Or the opposite - Being so fidgety or restless that you have been moving around a lot more than usual",
      noSubmit: false,
      fields: [
        {
          label: "bothered",
          placeholder: "",
          name: "bothered",
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
          label: "betterOffDead",
          placeholder: "",
          name: "betterOffDead",
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
        "How difficult has this made it for you to do your work, take care of things at home, or get along with other people?",
      noSubmit: false,
      fields: [
        {
          label: "difficultToDoWork",
          placeholder: "",
          name: "difficultToDoWork",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Extremely difficult",
              value: "Extremely difficult"
            },
            {
              text: "Very difficult",
              value: "Very difficult"
            },
            {
              text: "Somewhat difficult",
              value: "Somewhat difficult"
            },
            {
              text: "Not difficult at all",
              value: "Not difficult at all"
            }
          ]
        }
      ]
    },
    {
      question:
        "Are there any events in your life that may be contributing to how you’re feeling?",

      fields: [
        {
          label: "eventsInLife",
          placeholder: "",
          name: "eventsInLife",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Loss of a loved one",
              value: "Loss of a loved one"
            },
            {
              text: "Family or relationship challenges",
              value: "Family or relationship challenges"
            },
            {
              text: "School or career challenges",
              value: "School or career challenges"
            },
            {
              text:
                "Events or stressors (ex. big lifestyle changes, moving, new parent)",
              value:
                "Events or stressors (ex. big lifestyle changes, moving, new parent)"
            },
            {
              text: "Medical issues",
              value: "Medical issues"
            },
            {
              text: "Other",
              value: "Other"
            },
            {
              text: "None apply",
              value: "None apply",
              // next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "Do you suffer from any of the following? Choose all that apply.",

      fields: [
        {
          label: "eventsInLife",
          placeholder: "",
          name: "eventsInLife",
          type: "check",
          component: "Checkbox",
          options: [
            {
              text: "Stressful life events",
              value: "Stressful life events"
            },
            {
              text: "Sexual or physical abuse",
              value: "Sexual or physical abuse"
            },
            {
              text: "Emotional abuse, or emtional neglect",
              value: "Emotional abuse, or emtional neglect"
            },
            {
              text: "None",
              value: "None",
              // next: true
            }
          ]
        }
      ]
    },
    {
      question:
        "Has there ever been a period of time when you were not your usual self and you felt so good or so hyper that other people thought you were not your normal self or you were so hyper that you got into trouble?",
      noSubmit: false,
      fields: [
        {
          label: "hyper ",
          placeholder: "",
          name: "hyper",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "Yes",
              commit: "depressioninitial/Q29"
            },
            {
              text: "No",
              value: "No"
            }
          ]
        }
      ]
    },
    {
      question:
        "Has there ever been a period of time when you were not your usual self and you got much less sleep than usual and found you didn’t really miss it?",
      noSubmit: false,
      fields: [
        {
          label: "lessSleep ",
          placeholder: "",
          name: "lessSleep",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "Yes",
              commit: "depressioninitial/Q29"
            },
            {
              text: "No",
              value: "No"
            }
          ]
        }
      ]
    },
    {
      question:
        "Has there ever been a period of time when you were not your usual self and you were much more talkative or spoke faster than usual?",
      noSubmit: false,
      fields: [
        {
          label: "talkative ",
          placeholder: "",
          name: "talkative",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "Yes",
              commit: "depressioninitial/Q29"
            },
            {
              text: "No",
              value: "No"
            }
          ]
        }
      ]
    },
    {
      question:
        "Has there ever been a period of time when you were not your usual self and thoughts raced through your head or you couldn’t slow your mind down?",
      noSubmit: false,
      fields: [
        {
          label: "thoughtsRaced  ",
          placeholder: "",
          name: "thoughtsRaced",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "Yes",
              commit: "depressioninitial/Q29"
            },
            {
              text: "No",
              value: "No"
            }
          ]
        }
      ]
    },
    {
      question:
        "Has there ever been a period of time when you were not your usual self and you were so easily distracted by things around you that you had trouble concentrating or staying on track?",
      noSubmit: false,
      fields: [
        {
          label: " distractedByThings ",
          placeholder: "",
          name: "distractedByThings",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "Yes",
              commit: "depressioninitial/Q29"
            },
            {
              text: "No",
              value: "No"
            }
          ]
        }
      ]
    },
    {
      question:
        "Has there ever been a period of time when you were not your usual self and you did things that were unusual for you or that other people might have thought were excessive, foolish, or risky?",
      noSubmit: false,
      fields: [
        {
          label: "excessive ",
          placeholder: "",
          name: "excessive",
          type: "check",
          component: "Radio",
          options: [
            {
              text: "Yes",
              value: "Yes",
              commit: "depressioninitial/Q29"
            },
            {
              text: "No",
              value: "No"
            }
          ]
        }
      ]
    },
    {
      question:
        "Have your started to wonder if your mind was trying to trick you or was not working right?",
      noSubmit: false,
      fields: [
        {
          label: " mindWasTryingToTrick",
          placeholder: "",
          name: "mindWasTryingToTrick",
          type: "button",
          component: "CheckButtons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              commit: "depressioninitial/Q38",
              fields: [
                {
                  question: "Please provide a brief explination.",
                  lable: "",
                  placeholder: "",
                  name: "brief1",
                  component: "TextField"
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
        "Have you thought that the world may or may not be real or that you may not be real?",
      noSubmit: false,
      fields: [
        {
          label: " worldNotReal",
          placeholder: "",
          name: "worldNotReal",
          type: "button",
          component: "CheckButtons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              commit: "depressioninitial/Q38",
              action: "popup",
              fields: [
                {
                  question: "Please provide a brief explination.",
                  lable: "",
                  placeholder: "",
                  name: "brief2",
                  component: "TextField"
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
        "Have you heard unusual sounds like voices, banging, clicking, hissing, clapping or ringing that no one else could hear?",
      noSubmit: false,
      
      fields: [
        {
          label: " unusualSounds",
          placeholder: "",
          name: "mindWasTryingToTrick",
          type: "button",
          component: "CheckButtons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              commit: "depressioninitial/Q38",
              action: "popup",
              fields: [
                {
                  question: "Please provide a brief explination.",
                  lable: "",
                  placeholder: "",
                  name: "brief3",
                  component: "TextField"
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
        "Do you feel other people are watching/spying on you or talking about you?",
      noSubmit: false,
      fields: [
        {
          label: " peopleWatching ",
          placeholder: "",
          name: "peopleWatching",
          type: "button",
          component: "CheckButtons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              commit: "depressioninitial/Q38",
              action: "popup",
              fields: [
                {
                  question: "Please provide a brief explination.",
                  lable: "",
                  placeholder: "",
                  name: "brief4",
                  component: "TextField",
                  // required: true
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
        "Do you sometimes get strange feeling on or just beneath your skin, like bugs crawling?",
      noSubmit: false,
      fields: [
        {
          label: " strangeFeeling",
          placeholder: "",
          name: "strangeFeeling",
          type: "button",
          component: "CheckButtons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              commit: "depressioninitial/Q38",
              action: "popup",
              fields: [
                {
                  question: "Please provide a brief explination.",
                  lable: "",
                  placeholder: "",
                  name: "brief5",
                  component: "TextField"
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
        "Do you hold beliefs that other people would find unusual or bizarre?",
      noSubmit: false,
      fields: [
        {
          label: " bizarre",
          placeholder: "",
          name: "bizarre",
          type: "button",
          component: "CheckButtons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              commit: "depressioninitial/Q38",
              action: "popup",
              fields: [
                {
                  question: "Please provide a brief explination.",
                  lable: "",
                  placeholder: "",
                  name: "brief6",
                  component: "TextField"
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
        "Do you find yourself feeling mistrustful or suspicious of other people?",
      noSubmit: false,
      fields: [
        {
          label: " mistrustful",
          placeholder: "",
          name: "mistrustful",
          type: "button",
          component: "CheckButtons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              commit: "depressioninitial/Q38",
              fields: [
                {
                  question: "Please provide a brief explination.",
                  lable: "",
                  placeholder: "",
                  name: "brief7",
                  component: "TextField"
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
        "Have you seen things that other people can't see or don't seem to see?",
      noSubmit: false,
      fields: [
        {
          label: " seenThings ",
          placeholder: "",
          name: "seenThings",
          type: "button",
          component: "CheckButtons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  question: "Please provide a brief explination.",
                  lable: "",
                  placeholder: "",
                  name: "brief8",
                  component: "TextField"
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
        "If you are in a crisis, please call 911 or call the National Suicide Prevention Hotline  1-800-273-8225. To continue, please acknowledge that this is not an emergency situation.",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "inCrisis",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "I Acknowledge",
              value: "I Acknowledge",
              action: "input"
            }
          ]
        }
      ]
    }
  ],
  result: {
    form: "ed",
    gender: ""
  },
  qas: {}
});

const mutations = {
  Q29: function(state) {
    if (!state.questions.some(a => a.slug === "q29")) {
      state.questions.insert(40, {
        question:
          "how much of a problem did any of these cause you — like being able to work; having family, money, or legal troubles; getting into arguments or fights?",
        noSubmit: false,
        slug: "q29",
        fields: [
          {
            label: "theseCauseYou ",
            placeholder: "",
            name: "theseCauseYou",
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
      });
    }
  },
  Q38: function(state) {
    if (!state.questions.some(a => a.slug === "q38")) {
      state.questions.insert(48, {
        question:
          "how much of a problem did any of these cause you — like being able to work; having family, money, or legal troubles; getting into arguments or fights?",
        noSubmit: false,
        slug: "q38",
        fields: [
          {
            label: "theseCauseYou ",
            placeholder: "",
            name: "theseCauseYou",
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
      });
    }
  },
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
