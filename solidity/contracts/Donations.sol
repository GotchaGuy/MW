pragma solidity ^0.4.21;

contract AjDoniraj {

    struct Campaign {
        address campaignCreator;
        uint256 campaignCreatorId;
        string campaignTitle; //prepraviti u bytes32?
        uint8 category_id; 
        uint32 euro_goal;
        uint256 campaignStartTime;
        uint256 campaignDuration;
        uint8 overhead;
        uint32 totalDonatedSum;
        bool campaignEnded;
    }

    struct Donation {
        address donationCreator;
        uint256 donationCreatorId;
        uint32 euro_amount;
        uint256 campaign_id;
        uint8 plan_b;
        uint256 backup_campaign_id;
    }

    mapping(uint256 => Campaign) public campaigns;
    mapping(uint256 => Donation) public donations;
    
    // mapping(address => uint256) votedList;

    event CampaignResultEvent(uint256 campaignId, uint256 campaignCreatorId, string campaignTitle, uint8 overhead, uint32 euro_goal, uint32 totalDonatedSum,  uint8 category_id);
    event DonationnResultEvent(uint256 donationId, uint256 donationCreatorId, uint32 euro_amount, uint256 campaign_id, uint8 plan_b, uint256 backup_campaign_id);


    function createCampaign(uint256 _campaignId, uint256 _campaignCreatorId, string _campaignTitle, uint256 _campaignDuration, uint256 _campaignStartTime, uint8 _category_id, uint32 _euro_goal, uint8 _overhead) {
        campaigns[_campaignId].campaignCreator = msg.sender;
        campaigns[_campaignId].campaignCreatorId = _campaignCreatorId;
        campaigns[_campaignId].campaignTitle = _campaignTitle;
        campaigns[_campaignId].campaignStartTime = _campaignStartTime;
        campaigns[_campaignId].campaignDuration = _campaignDuration;
        campaigns[_campaignId].category_id = _category_id;
        campaigns[_campaignId].euro_goal = _euro_goal;
        campaigns[_campaignId].overhead = _overhead;
    }

    function donate(uint256 _donationId, uint256 _donationCreatorId, uint32 _euro_amount, uint256 _campaignId, uint8 _plan_b, uint256 _backup_campaign_id) {
        
        if(now > campaigns[_campaignId].campaignStartTime + campaigns[_campaignId].campaignDuration) {
            closeCampaign(_campaignId, _donationId); 
            throw; 
        }

        if(_euro_amount > 0) { 
            campaigns[_campaignId].totalDonatedSum += _euro_amount;
        } else {
            throw;
        }
        
        if(_plan_b < 1) { 
            _plan_b = 1;
        } 
        
        // if(_plan_b == 2) {
        //   // samo u ovom slucaju treba backup_campaign_id da bude popunjeno
        // }
        
        donations[_donationId].donationCreator = msg.sender;
        donations[_donationId].donationCreatorId = _donationCreatorId;
        donations[_donationId].euro_amount = _euro_amount;
        donations[_donationId].campaign_id = _campaignId;
        donations[_donationId].plan_b = _plan_b;
        donations[_donationId].backup_campaign_id = _backup_campaign_id;


    }

    function closeCampaign(uint256 _campaignId, uint256 _donationId) {
        if (now <= campaigns[_campaignId].campaignStartTime + campaigns[_campaignId].campaignDuration) {
            throw; 
        }

        if(campaigns[_campaignId].campaignEnded) {
            throw;
        }

        campaigns[_campaignId].campaignEnded = true;
        
       emit CampaignResultEvent( _campaignId, campaigns[_campaignId].campaignCreatorId, campaigns[_campaignId].campaignTitle, campaigns[_campaignId].overhead, campaigns[_campaignId].euro_goal, campaigns[_campaignId].totalDonatedSum, campaigns[_campaignId].category_id);
       emit DonationnResultEvent(_donationId, donations[_donationId].donationCreatorId, donations[_donationId].euro_amount, donations[_donationId].campaign_id, donations[_donationId].plan_b, donations[_donationId].backup_campaign_id);   
    }
    
    
}