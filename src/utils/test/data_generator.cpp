#include <bits/stdc++.h>
#define fore(i, l, r) for (long long i = (l); i < (r); i++)
#define forex(i, l, r) for (long long i = (l); i >= (r); i--)
#define ll long long
#define ull unsigned long long
#define nl cout<<"\n"
#define cnl "\n"
#define rfc "\033[31;1m"
#define gfc "\033[32;1m"
#define yfc "\033[33;1m"
#define bfc "\033[34;1m"
#define pfc "\033[35;1m"
#define cfc "\033[36;1m"
#define nfc "\033[0m"
#define pb push_back
using namespace std;

vector<string> names, lastNames, places;

std::string getCurrentTimeString() {
    std::time_t now=std::time(nullptr);
    std::tm* localTime=std::localtime(&now);
    std::ostringstream oss;
    oss<<std::put_time(localTime, "%Y-%m-%d %H:%M:%S");

    return oss.str();
}

int randomNumber(int n){
	int x=rand() % n;
	return x;
}

string encrypt(string raw, int size){
    vector<ull> v(size, 0);
    string s="";
    ull aux;
    for(int i=0; i<raw.size(); i++){
        v[i]=raw[i];
        aux=i;
    }
    for(int i=aux; i<raw.size(); i++){
        v[i]=i*7+13*(i/3);
    }
    aux=10;
    for(int i=0; i<size; i++){
        v[i]+=aux;
        aux+=v[i];
    }
    for(int i=size-1; i>=0; i--){
        v[i]+=aux+7;
        aux+=v[i];
    }
    for(int i=0; i<size; i++){
        v[i]%=70;
        if(v[i]<26) s+=char('A'+v[i]);
        else if(v[i]<52) s+=char('a'+v[i]-26);
        else if(v[i]<62) s+=char('0'+v[i]-52);
        else{
            switch(v[i]-62){
                case 0: s+='#'; break;
                case 1: s+='$'; break;
                case 2: s+='&'; break;
                case 3: s+='('; break;
                case 4: s+=')'; break;
                case 5: s+='*'; break;
                case 6: s+='+'; break;
                case 7: s+=','; break;
                case 8: s+='-'; break;
                case 9: s+='.'; break;
            }
        }
    }

    return s;
}

void addNames(string s){
	string aux="";
	fore(i,0,s.size()){
		if(s[i]==' '){
			names.push_back(aux);
			aux="";
		}else{
			aux+=s[i];
		}
	}
	names.push_back(aux);
}

void addLastnames(string s){
	string aux="";
	fore(i,0,s.size()){
		if(s[i]==' '){
			lastNames.push_back(aux);
			aux="";
		}else{
			aux+=s[i];
		}
	}
	lastNames.push_back(aux);
}

void addPlaces(string s){
	string aux="";
	fore(i,0,s.size()){
		if(s[i]==' '){
			places.push_back(aux);
			aux="";
		}else{
			aux+=s[i];
		}
	}
	places.push_back(aux);
}

class User {
public:
    long long idUser;
    std::string givenname;
    std::string fLastName;
    std::string mLastName;
    std::string username;
    std::string accessKey;

    User(long long id, const std::string& user, const std::string& firstName, const std::string& lastName, std::string uname, const std::string& key) : idUser(id), givenname(user), fLastName(firstName), mLastName(lastName), username(uname), accessKey(key) {}

    void printInsertSQL() const {
        std::cout << "INSERT INTO User (IDUser, givenname, FLastName, MLastName, Username, AccessKey) VALUES ("
        << idUser << ", '" 
        << givenname << "', '"
        << fLastName << "', '"
        << mLastName << "', '"
        << username << "', '"
        << accessKey << "');" 
        << std::endl;
    }
};

class Device {
public:
    long long idDevice;
    std::string accessKey;
    std::string place;

    Device(long long id, const std::string& key, const std::string& loc) : idDevice(id), accessKey(key), place(loc) {}

    void printInsertSQL() const {
        std::cout << "INSERT INTO Device (IDDevice, AccessKey, Place) VALUES ("
        << idDevice << ", '"
        << accessKey << "', '"
        << place << "');" 
        << std::endl;
    }
};

class UserDevice {
public:
    long long idUser;
    long long idDevice;

    UserDevice(long long userId, long long deviceId) : idUser(userId), idDevice(deviceId) {}

    void printInsertSQL() const {
        std::cout << "INSERT INTO User_Device (IDUser, IDDevice) VALUES ("
        << idUser << ", "
        << idDevice << ");"
        << std::endl;
    }
};

class Record {
public:
    long long idRecord;
    string readTime;
    float temperature;
    float humidity;
    float ppm;
    long long idDevice;

    Record(long long id, float temp, float hum, float gasPpm, long long deviceId) : idRecord(id), temperature(temp), humidity(hum), ppm(gasPpm), idDevice(deviceId) {
        readTime = getCurrentTimeString();
    }

    void printInsertSQL() const {
        std::cout << "INSERT INTO Record (IDRecord, ReadTime, Temperature, Humidity, Ppm, IDDevice) VALUES ("
        << idRecord << ", '"
        << readTime << "', "
        << temperature << ", "
        << humidity << ", "
        << ppm << ", "
        << idDevice << ");"
        << std::endl;
    }
};

int main(){
	srand (time(NULL));
	ios_base::sync_with_stdio(0);
	cin.tie(0);
	freopen("input.txt", "r", stdin);
	freopen("insert_test_data.sql","w", stdout);

	string aux;

	getline(cin,aux);
	addNames(aux);

    getline(cin,aux);
	addLastnames(aux);

    getline(cin,aux);
	addPlaces(aux);

    vector<User> users;
    for(int i=0; i<30; i++){
        string name=names[randomNumber(names.size())];
        string mlastname=lastNames[randomNumber(lastNames.size())];
        string flastname=lastNames[randomNumber(lastNames.size())];
        users.push_back(User(i+1, name, flastname, mlastname, encrypt(name.substr(0,5)+flastname.substr(0,6)+mlastname.substr(0,6), 20), encrypt(name, 15)));
        users[i].printInsertSQL();
    }
    cout<<"\n";    

    vector<Device> devices;
    for(int i=0; i<15; i++){
        string place=places[randomNumber(places.size())];
        devices.push_back(Device(i+1, encrypt(getCurrentTimeString(), 20), place));
        devices[i].printInsertSQL();
    }
    cout<<"\n";  

    vector<UserDevice> users_devices;
    for(int i=0; i<20; i++){
        UserDevice aux=UserDevice(users[randomNumber(users.size())].idUser, devices[randomNumber(devices.size())].idDevice);
        bool q=0;
        for(int j=0; j<users_devices.size(); j++){
            if(users_devices[j].idDevice==aux.idDevice && users_devices[j].idUser==aux.idUser){
                q=1;
                break;
            }
        }
        if(q==1){
            i--;
            continue;
        }
        users_devices.push_back(aux);
        users_devices[i].printInsertSQL();
    }
    cout<<"\n";  

    vector<Record> records;
    for(int i=0; i<500; i++){
        records.push_back(Record(i+1, randomNumber(100), randomNumber(100), randomNumber(100), devices[randomNumber(devices.size())].idDevice));
        records[i].printInsertSQL();
    }
}