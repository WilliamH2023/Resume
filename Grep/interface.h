/*
* COMP15 Homework 04 , Summer 2020
* interface. h
* By : William Huang
* Completed : August 6, 2020
*
* Gerp Interface
* Purpose : This header contains all helper functions of GERP and serves as 
*           an interface of GERP. It mainly contains a hash table that stores
*           word info, as well as vectors storing file directories and lines.
*           Gerp supports word search and case_insensitive_search.
*/

#ifndef INTERFACE_H
#define INTERFACE_H
#include<iostream>
#include<sstream>
#include <fstream>
#include<stdio.h>
#include<string.h>
#include<ctype.h>
#include<vector>
#include "word.h"
#include "index_dir.h"

//helper functions
int example_hash(std::string input);
std::string stripNonAlphaNum(std::string input);
std::vector<std::string> break_down_query(std::string query);
std::string lowerCase(std::string input);
std::string toStringWord(Word input, std::vector<std::string> const &directory,
                         std::vector<std::string> const &line);
bool check_for_repetition(std::vector<std::string> &temp_string,
                          std::string temp_word);

//search functions
void search(std::string query, std::vector<std::vector<Word> > const &word_table,
            std::vector<std::string> const &directory,
            std::vector<std::string> const &line);
void case_insensitive_search(std::string query, 
                             std::vector<std::vector<Word> > const &word_table, 
                             std::vector<std::string> const &directory,
                             std::vector<std::string> const &line);

//read_file functions
void read_directory(std::string input, std::vector<std::string> &directory,
                    std::vector<std::string> &line, 
                    std::vector<std::vector<Word> > &word_table);              
void read_file(int dir_index, std::string file_directory, 
               std::vector<std::string> &line, 
               std::vector<std::vector<Word> > &word_table);


#endif