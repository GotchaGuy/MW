[
	{
		"constant": false,
		"inputs": [
			{
				"name": "_campaignId",
				"type": "uint256"
			},
			{
				"name": "_donationId",
				"type": "uint256"
			}
		],
		"name": "closeCampaign",
		"outputs": [],
		"payable": false,
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"constant": false,
		"inputs": [
			{
				"name": "_campaignId",
				"type": "uint256"
			},
			{
				"name": "_campaignTitle",
				"type": "string"
			},
			{
				"name": "_campaignDuration",
				"type": "uint256"
			},
			{
				"name": "_campaignStartTime",
				"type": "uint256"
			},
			{
				"name": "_category_id",
				"type": "uint8"
			},
			{
				"name": "_euro_goal",
				"type": "uint32"
			},
			{
				"name": "_overhead",
				"type": "uint8"
			}
		],
		"name": "createCampaign",
		"outputs": [],
		"payable": false,
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"constant": false,
		"inputs": [
			{
				"name": "_donationId",
				"type": "uint256"
			},
			{
				"name": "_euro_amount",
				"type": "uint32"
			},
			{
				"name": "_campaignId",
				"type": "uint256"
			},
			{
				"name": "_plan_b",
				"type": "uint8"
			},
			{
				"name": "_backup_campaign_id",
				"type": "uint256"
			},
			{
				"name": "_totalDonatedSum",
				"type": "uint32"
			}
		],
		"name": "donate",
		"outputs": [],
		"payable": false,
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"name": "campaignId",
				"type": "uint256"
			},
			{
				"indexed": false,
				"name": "campaignTitle",
				"type": "string"
			},
			{
				"indexed": false,
				"name": "overhead",
				"type": "uint8"
			},
			{
				"indexed": false,
				"name": "euro_goal",
				"type": "uint32"
			},
			{
				"indexed": false,
				"name": "totalDonatedSum",
				"type": "uint32"
			},
			{
				"indexed": false,
				"name": "category_id",
				"type": "uint8"
			}
		],
		"name": "CampaignResultEvent",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": false,
				"name": "donationId",
				"type": "uint256"
			},
			{
				"indexed": false,
				"name": "euro_amount",
				"type": "uint32"
			},
			{
				"indexed": false,
				"name": "campaign_id",
				"type": "uint256"
			},
			{
				"indexed": false,
				"name": "plan_b",
				"type": "uint8"
			},
			{
				"indexed": false,
				"name": "backup_campaign_id",
				"type": "uint256"
			}
		],
		"name": "DonationnResultEvent",
		"type": "event"
	},
	{
		"constant": true,
		"inputs": [
			{
				"name": "",
				"type": "uint256"
			}
		],
		"name": "campaigns",
		"outputs": [
			{
				"name": "campaignCreator",
				"type": "address"
			},
			{
				"name": "campaignTitle",
				"type": "string"
			},
			{
				"name": "category_id",
				"type": "uint8"
			},
			{
				"name": "euro_goal",
				"type": "uint32"
			},
			{
				"name": "campaignStartTime",
				"type": "uint256"
			},
			{
				"name": "campaignDuration",
				"type": "uint256"
			},
			{
				"name": "overhead",
				"type": "uint8"
			},
			{
				"name": "totalDonatedSum",
				"type": "uint32"
			},
			{
				"name": "campaignEnded",
				"type": "bool"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [
			{
				"name": "",
				"type": "uint256"
			}
		],
		"name": "donations",
		"outputs": [
			{
				"name": "donationCreator",
				"type": "address"
			},
			{
				"name": "euro_amount",
				"type": "uint32"
			},
			{
				"name": "campaign_id",
				"type": "uint256"
			},
			{
				"name": "plan_b",
				"type": "uint8"
			},
			{
				"name": "backup_campaign_id",
				"type": "uint256"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	}
]