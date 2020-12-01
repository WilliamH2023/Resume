/*
* COMP15 Homework 04 , Summer 2020
* interface. cpp
* By : William Huang
* Completed : August 6, 2020
*
* Grep Implementation
* Purpose : This header contains all helper functions of GREP and serves as 
*           an interface of GREP. It mainly contains a hash table that stores
*           word info, as well as vectors storing file directories and lines.
*           GREP supports word search and case_insensitive_search.
*/
#include "interface.h"


const std::string CASE_INSENSITIVE = "@i";
const std::string QUIT = "@q";

/*
* example_hash
* Purpose : Given a string, output a int as an index of the array which will 
*           store the string.
* Note : Range: 0 ~ 1599999.
*/
int example_hash(std::string input){
  int result = std::hash<std::string>{}(input);
  return abs(result % 1600000);
}

/*
* stripNonAlphaNum [helper function]
* Purpose : Given a string, strip all of its nonalphanumerical letters at the 
*           beginning and at the end.
* Note : Its nonalphanumerical letters stay.
*/
std::string stripNonAlphaNum(std::string input){
  int length = input.length();
  int start = 0;
  int end = length - 1;
  std::string stripped;
  
  for (int i = 0; i < length; i++) {
    start = i;
    if (isalnum(input[i]))    break;
  }
  for (int i = length-1; i >= 0; i--) {
    end = i;
    if (isalnum(input[i]))    break;
  }
  
  if (start > end)            return "";
  for (int i = start; i <= end; i++) {
    stripped += input[i];
  }
  return stripped;
}

/*
* break_down_query [helper function]
* Purpose : Given a string, break it down into words and store them in a vector.
*/
std::vector<std::string> break_down_query(std::string query){
  std::vector<std::string> input;
  std::stringstream s;
  std::string temp;
  s << query;
  
  while (s >> temp)     input.push_back(temp);
  return input;
  
}

/*
* lowerCase [helper function]
* Purpose : Given a string, make all of its letter lowercased.
*/
std::string lowerCase(std::string input){
  std::stringstream s; 
  
  for (size_t i = 0; i < input.length(); i++) {
    char curr = input[i];
    if (isupper(curr))            curr = tolower(curr); 
    s << curr;
  }
  return s.str();
}

/*
* toStringWord
* Purpose : Given a Word class object, return a string that contains its 
*           directory, line number, and line. 
* Note : Format:    PathWithFileName:LineNum: Line 
*/
std::string toStringWord(Word word, std::vector<std::string> const &directory,
                         std::vector<std::string> const &line){
  std::stringstream s; 
  s << directory[word.getDirectory()] << ":" << word.getLineNum() << ": ";
  s << line[word.getLine()] << "\n";
  return s.str();
}

/*
* search
* Purpose : Given a string to search for, use toStringWord to std::cout all  
*           words that match with our input.
* Note : Using Hash Table to extract info.
*/
void search(std::string query, std::vector<std::vector<Word> > const &word_table, 
            std::vector<std::string> const &directory,
            std::vector<std::string> const &line) {
  int count = 0;
  std::string query_lowered = lowerCase(query);
  std::vector<Word> target = word_table[example_hash(query_lowered)];
  for (int i = 0; i < target.size(); i++) {
    if (target[i].getWord() == query) {
      std::cout << toStringWord(target[i], directory, line);
      ++count;
    }
  }
  
  if (count == 0) {
    std::cout << query << "Not Found. Try case insensitive search with @i.";
  }
}

/*
* case_insensitive_search
* Purpose : Given a string to search for, use toStringWord to std::cout all  
*           words that match with our input.
* Note : Case Insenstive. Each group of case insensitive words are chained in
*        one bucket (i.e. they have the same index in hash table).
*/
void case_insensitive_search(std::string query, 
                             std::vector<std::vector<Word> > const &word_table, 
                             std::vector<std::string> const &directory,
                             std::vector<std::string> const &line){
  query = lowerCase(query);
  int count = 0;
  std::vector<Word> target = word_table[example_hash(query)];
  for (int i = 0; i < target.size(); i++) {
    std::string curr = target[i].getWord();
    if (lowerCase(curr) == query) {
      std::cout << toStringWord(target[i], directory, line);
      ++count;
    }
  }
  if (count == 0) {
    std::cout << query << " Not Found.\n";
  }
  
}

/*
* check_for_repetition [helper function]
* Purpose : Given a string to compare with, if it has not appeared in the line
*           we are reading yet, store it in a vector and return false. If it
*           has appeared in the line before, return false.
* Note : Designed for reading lines in read_file function.
*/
bool check_for_repetition(std::vector<std::string> &temp_string,
                          std::string temp_word){
  if (temp_string.size() != 0) {
    for (int i = 0; i < temp_string.size(); i++) {      
      if (temp_word == temp_string[i]) {
        return true;
      }    
    }
  }
  temp_string.push_back(temp_word);
  return false;
}

/*
* read_directory
* Purpose : Given a directory as string, use read_file to read every file 
*           under the given directory. Note that every file's directory with 
*           filename is stored in a vector.
*/
void read_directory(std::string input, std::vector<std::string> &directory,
                    std::vector<std::string> &line, 
                    std::vector<std::vector<Word> > &word_table){
                      
  directory = index_dir(input); 
  if (directory.size() == 0) return;
  
  for (int i = 0; i < directory.size(); i++) {
    read_file(i, directory[i], line, word_table);
  }
};

/*
* read_file
* Purpose : Given a file directory as string, store each line of the file in a 
*           vector, and store each word as a Word class object in the hash table.
* Note : Words that repeatedly appear in the same line will only be stored once.
*        Each bucket in the hash table contains not only the word itself, but 
*        also its case insensitive variants.
*/
void read_file(int dir_index, std::string file_directory, 
               std::vector<std::string> &line, 
               std::vector<std::vector<Word> > &word_table){
  
  std::ifstream infile(file_directory);
  std::string line_info;
  std::stringstream s; 
  int line_number = 0;
  
  while(getline(infile, line_info)){ //store a line in line_info
    std::vector<std::string> temp_string;
    ++line_number;
    line.push_back(line_info);
    int line_index = line.size() - 1;
    std::string temp_word;
    
    s << line_info; 
    while (s >> temp_word) {
      temp_word = stripNonAlphaNum(temp_word);
      if (check_for_repetition(temp_string, temp_word)) continue;
      
      std::string temp_word_lowered = lowerCase(temp_word);
      int hash_index = example_hash(temp_word_lowered);
      Word curr(temp_word, dir_index, line_index, line_number);
      word_table[hash_index].push_back(curr);
      temp_string.push_back(temp_word);
      
    }
    s.clear(); 
  }
}; 





int main(int argc, char const *argv[]) {  
  
  if (argc < 2) {
    std::cerr << "ERROR: No filename provided as an argument\n";
    exit(EXIT_FAILURE);
  }
  //read files
  std::vector<std::vector<Word>> word_table(1600000);
  std::vector<std::string> directory;
  std::vector<std::string> line;
  read_directory(std::string(argv[1]), directory, line, word_table);
  
  //Interface
  std::string query;
  std::cout << "Query? ";
  while (getline (std::cin, query)) {
    std::vector<std::string> input = break_down_query(query);
    if (input[0] == CASE_INSENSITIVE and input.size() == 2) {
      std::string temp = stripNonAlphaNum(input[1]);
      case_insensitive_search(temp, word_table, directory, line);
    }
    
    else if (input.size() == 1 and input[0] == QUIT) {
      std::cout << "Goodbye! Thank you and have a nice day.\n";
      return 0;
    }      
    
    else if (input.size() == 1) {
      std::string temp = stripNonAlphaNum(input[0]);
      search(temp, word_table, directory, line);
    }
    std::cout << "\nQuery? ";
  }

}
